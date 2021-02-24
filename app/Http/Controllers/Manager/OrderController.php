<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Restaurant;

class OrderController extends Controller
{
    function index(){
        $user = Auth::user();
        $selRest = Restaurant::find($user->restaurant_id);
        
        $menus = $selRest->menus()->where("foodAvailable", true)->get();
        $tables = $selRest->tables;

    	return view('manager.orders', compact('user', 'menus', 'tables'));
    }
}
