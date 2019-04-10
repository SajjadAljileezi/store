<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class CheckOutController extends Controller
{
    public function index(){
        $countries=DB::table('countries')->get();
        $user_login=User::where('id',Auth::id())->first();
        return view('checkout.index',compact('countries','user_login'));
    }
    public function submitcheckout(Request $request){
        $validator = Validator::make($request->all(),[
           'billing_company'=>'required',
           'billing_street1'=>'required',
           'billing_city'=>'`required',
           'billing_state'=>'required',
           'billing_zip'=>'required',
           'billing_phone'=>'required',
           'shipping_company'=>'required',
           'shipping_street1'=>'required',
           'shipping_city'=>'required',
           'shipping_state'=>'required',
           'shipping_zip'=>'required',
           'shipping_phone'=>'required',
       ]);
        $input_data=$request->all();
       $count_shippingaddress=DB::table('delivery_address')->where('users_id',Auth::id())->count();
       if($count_shippingaddress==1){
           DB::table('delivery_address')->where('users_id',Auth::id())->update(['company'=>$input_data['shipping_company'],
               'street1'=>$input_data['shipping_street1'],
               'city'=>$input_data['shipping_city'],
               'state'=>$input_data['shipping_state'],
               'country'=>$input_data['shipping_country'],
               'zip'=>$input_data['shipping_zip'],
               'phone'=>$input_data['shipping_phone']]);
       }else{
            DB::table('delivery_address')->insert(['users_id'=>Auth::id(),
                'users_email'=>Session::get('frontSession'),
                'company'=>$input_data['shipping_company'],
                'street1'=>$input_data['shipping_street1'],
                'city'=>$input_data['shipping_city'],
                'state'=>$input_data['shipping_state'],
                'country'=>$input_data['shipping_country'],
                'zip'=>$input_data['shipping_zip'],
                'phone'=>$input_data['shipping_phone'],]);
       }
        DB::table('users')->where('id',Auth::id())->update(['company'=>$input_data['billing_company'],
            'street1'=>$input_data['billing_street1'],
            'city'=>$input_data['billing_city'],
            'state'=>$input_data['billing_state'],
            'country'=>$input_data['billing_country'],
            'zip'=>$input_data['billing_zip'],
            'phone'=>$input_data['billing_phone']]);
       return redirect('/order-review');

    }
}
