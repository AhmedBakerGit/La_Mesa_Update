<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Admin;

class RegisterController extends Controller
{
    // protected function guard() {
    //     return Auth::guard('admin');
    // }

    function index(){
    	return view('admin.register');
    }

    function submit(Request $request) {
        $request->validate([
            'f_name' => "required",
            'l_name' => "required",
            'email' => "required|email|unique:admins",
            // 'password' => "required|confirmed",
            'password' => "required",
        ]);

        // $input = $request->all();
        
        $admin = new Admin;

        $admin->f_name = $request->f_name;
        $admin->l_name = $request->l_name;
        $admin->name = $request->f_name.' '.$request->l_name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->contact = $request->contact;
        $admin->company = $request->company;
        $admin->comaddress = $request->comaddress;
        $admin->comcontact = $request->comcontact;

        $admin->save();

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('admin/restaurants');
        }
    }
}
