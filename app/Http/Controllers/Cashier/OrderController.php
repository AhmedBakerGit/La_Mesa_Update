<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Restaurant;
use Illuminate\Support\Facades\Hash;
class OrderController extends Controller
{
    function index(){
        $user = Auth::user();
        $selRest = Restaurant::find($user->restaurant_id);
        
        $menus = $selRest->menus()->where("foodAvailable", true)->get();
        $tables = $selRest->tables;

    	return view('cashier.orders', compact('user', 'menus', 'tables'));
    }

    function checkManagerCredentials(Request $request) {
        $user = Auth::user();
        
        $res = [];
        $res['status'] = 0;
        $res['msg'] = "Invalid user name or password";

        $manager = Restaurant::find($user->restaurant_id)
                    ->staffs()
                    ->where("name", $request->name)
                    ->first();

        if ($manager) {
            if (Hash::check($request->password, $manager->password)) {
                $res['status'] = 1;
                $res['msg'] = "Passed!";
            }
        }

        return response()->json($res, 200);
    }
}
