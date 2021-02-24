<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function index(){
        $user = Auth::user();
        // $id = Auth::id();
        // Auth::logout();

    	return view('kitchen.orders', compact('user'));
    }
}
