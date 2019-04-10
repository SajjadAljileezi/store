<?php

namespace App\Http\Controllers;

use App\Orders_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cart_model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ShippingController extends Controller
{
    public function index()
    {
        
       
    }

    
    public function shipping(){
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
            
          ));
         
            //  return $shipments;
          
          // return view('frontEnd.cart')->with("shipments",$shipments);
          // return view('frontEnd.cart',compact('shipments'));


          }
          
          
    }
     


