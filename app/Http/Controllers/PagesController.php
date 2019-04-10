<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Orders_model;


class PagesController extends Controller
{
    public function index(){
        $menu_active=1;
        return view('backEnd.pages',compact('menu_active'));
    }
    public function buying(Request $request){
        $who_buyings=Orders_model::where('is_completed', false)->get();
        $menu_active=1;
        return view('backEnd.pages',compact('who_buyings','menu_active'));
    }
    public function completed($id){
        \DB::table('orders')->where('id', $id)->update(array('is_completed' => 1));
        $menu_active=1;
        $who_buyings=Orders_model::where('is_completed', false)->get();
        return view('backEnd.pages',compact('menu_active','who_buyings'));
    }
}
