<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    function index(){
        $user = Auth::user();

    	return view('manager.bills', compact('user'));
    }
}
