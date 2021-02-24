<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Restaurant;

class MobileController extends Controller
{
    public function checkRestaurant(Request $request)
    {
        $res = [];
        $res['status'] = 0;
        $res['msg'] = 'Restaurant does not exist!';
        
        if ($request->restauarnt_id && $request->tableNum) {

            $table = Restaurant::find($request->restauarnt_id)->tables()->where("tableNum", $request->tableNum)->first();
            if ($table) {
                
                if ($table->tableStatus === 1) {
                    // table is occupied
                    $res['status'] = 0;
                    $res['msg'] = 'Table is already occupied. Try with other table';
                } else {
                    // table is not occupied
                    $table->tableStatus = 1;
                    $table->save();

                    $res['status'] = 1;
                    $res['msg'] = 'Restaurant exist';
                }
                
            }
        }         

        return response()->json($res, 200);
    }

    public function getMenus(Request $request)
    {
        $res = [];
        $res['status'] = 0;
        $res['msg'] = 'Restaurant does not exist!';
        $res['restName'] = "";
        
        if ($request->restauarnt_id) {

            $restauarntName = Restaurant::find($request->restauarnt_id)->restName;
            $res['restName'] = $restauarntName;

            $menus = Restaurant::find($request->restauarnt_id)->menus()->where("foodAvailable", true)->get();
            if (count($menus) > 0) {
                $res['data'] = $menus;
                $res['status'] = 1;
                $res['msg'] = 'Okay';
            } else {
                $res['status'] = 0;
                $res['msg'] = 'Menu does not exist!';
            }
        } 

        return response()->json($res, 200);
    }

    public function exit(Request $request)
    {
        $res = [];
        $res['status'] = 0;
        $res['msg'] = 'Restaurant does not exist!';
        
        if ($request->restauarnt_id && $request->tableNum) {

            $table = Restaurant::find($request->restauarnt_id)->tables()->where("tableNum", $request->tableNum)->first();
            if ($table) {
                $table->tableStatus = 0;
                $table->save();

                $res['status'] = 1;
                $res['msg'] = 'Success';
            }
        }         

        return response()->json($res, 200);
    }
}
