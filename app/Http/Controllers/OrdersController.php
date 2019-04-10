<?php

namespace App\Http\Controllers;

use App\Cart_model;
use App\Orders_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Notification;
use App\Notifications\OrderComplete;
class OrdersController extends Controller
{
    public function index(){
        $session_id=Session::get('session_id');
        $cart_datas=Cart_model::where('session_id',$session_id)->get();
        $total_price=0;
        foreach ($cart_datas as $cart_data){
            $total_price+=$cart_data->price*$cart_data->quantity;
        }
        $shipping_street1=DB::table('delivery_address')->where('users_id',Auth::id())->first();
        if($user = Auth::user()){
            $address_pa = DB::table('delivery_address')->where('users_id',Auth::id())->get();
            $to_address= json_decode(trim($address_pa, '[]'),true);
              //  return $to_address;
            
            $from_address = array(
                "verify"  => array("delivery"),
                "street1" => "1542 Jefferson Street",
                "city"    => "Teaneck",
                "state"   => "nj",
                "zip"     => "07666",
                "country" => "US",
                "company" => "EasyPost",
                "phone"   => "415-123-4567"
            );
    
            $parcel = array(
                "length" => 20.2,
                "width" => 10.9,
                "height" => 5,
                "weight" => 65.9
              );
            
            $to_address = \EasyPost\Address::create($to_address );
            $from_address = \EasyPost\Address::create($from_address);
            $parcel = \EasyPost\Parcel::create($parcel);
    
            $shipments = \EasyPost\Shipment::create(array(
                "to_address" => $to_address,
                "from_address" => $from_address,
                "parcel" => $parcel,
                "options" => array('address_validation_level' => 0)
               
            )); }else {
                 
            }
        return view('checkout.review_order',compact('shipping_street1','cart_datas','total_price','shipments'));
    }
    public function order(Request $request){
        $input_data=$request->all();
        $payment_method=$input_data['payment_method'];
        Orders_model::create($input_data);
        if($payment_method=="COD"){
            return redirect('/cod');
        }else{
            return redirect('/paypal');
        }
    }
    public function cod(){
        $user_order=Orders_model::where('users_id',Auth::id())->first();
        $user_order->notify(new OrderComplete());
        return view('payment.cod',compact('user_order'));
    }
    public function paypal(Request $request){
        $who_buying=Orders_model::where('users_id',Auth::id())->first();
        $who_buying->notify(new OrderComplete());
        return view('payment.paypal',compact('who_buying'));
        
        

    }
}
