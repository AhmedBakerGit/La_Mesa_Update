<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // protected function guard() {
    //     return Auth::guard('admin');
    // }

    // public function username()
    // {
    //     return 'username';
    // }

    function index(){
    	return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        // $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
        // if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('admin/restaurants');
        }

        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
