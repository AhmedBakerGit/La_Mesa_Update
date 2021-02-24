<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Restaurant;
use App\Menu;
use App\Staff;

class MenuController extends Controller
{
    public function index(){
        $restaurant_id = Auth::user()->restaurant_id;
        $selRest = Restaurant::find($restaurant_id);
        
        $tables = $selRest->tables;
        $menus = $selRest->menus;

        return view('manager.menu', compact('selRest'));
    }

    public function getMenuAll(Request $request)
    {
        $restaurant_id = Auth::user()->restaurant_id;
        $restName = Restaurant::find($restaurant_id)->restName;
        $menus = Restaurant::find($restaurant_id)->menus()->orderBy('foodName')->get();

        $record = array();
        $res['data'] = [];

        foreach ($menus as $menu) {
            $record['id'] = $menu->id;
            // $record['restName'] = $restName;
            $record['foodName'] = $menu->foodName;
            $record['foodPrice'] = $menu->foodPrice;
            $record['foodDescription'] = $menu->foodDescription;
            $record['foodPicUrl'] = $menu->foodPicUrl;
            $record['foodAvailable'] = $menu->foodAvailable;

            $res['data'][] = $record;
        }
        
        $res['recordsTotal'] = count($menus);
        $res['recordsFiltered'] = count($menus);

        return response()->json($res, 200);
    }

    public function getMenuAvailable(Request $request)
    {
        $res['status'] = 0;
        $restaurant_id = Auth::user()->restaurant_id;
        $restName = Restaurant::find($restaurant_id)->restName;
        $menus = Restaurant::find($restaurant_id)->menus()->where('foodAvailable', 1)->orderBy('foodName')->get();

        $record = array();
        $res['data'] = [];

        foreach ($menus as $menu) {
            $record['id'] = $menu->id;
            $record['foodName'] = $menu->foodName;
            $record['foodPrice'] = $menu->foodPrice;
            $record['foodDescription'] = $menu->foodDescription;
            $record['foodPicUrl'] = $menu->foodPicUrl;
            $record['foodAvailable'] = $menu->foodAvailable;

            $res['data'][] = $record;
        }
        
        $res['recordsTotal'] = count($menus);
        $res['recordsFiltered'] = count($menus);
        $res['status'] = 1;

        return response()->json($res, 200);
    }

    public function changeAvailable(Request $request)
    {
        $res = [];
        $res['status'] = 0;
        $res['msg'] = "";

        $id = $request->menu_id;
        $menu = Menu::find($id);
        $available = $menu->foodAvailable;
        if($available == 0) $menu->foodAvailable = 1;
        else $menu->foodAvailable = 0;

        $menu->save();

        $res['status'] = 1;
        $res['msg'] = "Change Success!";
        return response()->json($res, 200);
    }
}
