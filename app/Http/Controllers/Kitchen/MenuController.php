<?php

namespace App\Http\Controllers\Kitchen;

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

        return view('kitchen.menu', compact('selRest'));
    }
}
