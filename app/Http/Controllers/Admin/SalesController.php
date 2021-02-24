<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    function index()
    {
        $admin = Auth::guard('admin')->user();
        $restaurants = $admin->restaurants;

        return view('admin.sales', compact('restaurants'));
    }
}
