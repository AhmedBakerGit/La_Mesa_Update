<?php

namespace App\Http\Controllers\StaffAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('staff.login');
    }

    function index(){
    	return view('login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('checkstaff');
        }

        return back()->withInput($request->only('name', 'remember'));
    }

    public function checkstaff()
    {
        $user = Auth::user();
        // $id = Auth::id();
        // $role = $user->role->role;
        $role_id = $user->role_id;

        switch($role_id) {
            case config('roles.manager'):
                return redirect('manager/orders');

            case config('roles.cashier'):
                return redirect('cashier/orders');

            case config('roles.kitchen'):
                return redirect('kitchen/orders');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
