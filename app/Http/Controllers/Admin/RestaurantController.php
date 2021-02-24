<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Restaurant;

class RestaurantController extends Controller
{
    function index(){
        $admin = Auth::guard('admin')->user();
        // $id = Auth::guard('admin')->id();
        // Auth::guard('admin')->logout();

        $restaurants = $admin->restaurants;

        return view('admin.restaurants', compact('restaurants'));
    }

    public function getRestInfo(Request $request)
    {
        $res = Restaurant::find($request->id);

        return response()->json($res, 200);
    }

    public function submit(Request $request)
    {
        if ($request->restaurant_id) {
            // update
            $request->validate([
                'restName' => 'required',
                'restAddress' => 'required'
            ]);

            $restaurant = Restaurant::find($request->restaurant_id);

        } else {
            // insert
            $request->validate([
                'restName' => 'required|unique:restaurants',
                'restAddress' => 'required'
            ]);

            $restaurant = new Restaurant;
        }

        $restaurant->restName = $request->restName;
        $restaurant->restAddress = $request->restAddress;
        $restaurant->restTelephone = $request->restTelephone;
        $restaurant->restCellphone = $request->restCellphone;
        $restaurant->restDescription = $request->restDescription;
        $restaurant->admin_id = Auth::guard('admin')->id();

        try {
            $restaurant->save();
        } catch (\Throwable $th) {
            
        }
        
        $admin = Auth::guard('admin')->user();
        $restaurants = $admin->restaurants;

        return view('admin.restaurants', compact('restaurants'));
    }

    public function delete(Request $request)
    {
        if ($request->id){
            $restaurant = Restaurant::find($request->id);
            $restaurant->delete();
        }

        $res = [];
        return response()->json($res, 200);
    }
}
