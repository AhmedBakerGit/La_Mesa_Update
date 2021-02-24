<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    function index(){
        $user = Auth::user();

    	return view('cashier.request', compact('user'));
    }
}
