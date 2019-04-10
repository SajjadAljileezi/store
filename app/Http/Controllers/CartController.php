<?php
namespace App\Http\Controllers;
use App\Cart_model;
use App\ProductAtrr_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        $session_id=Session::get('session_id');
        $cart_datas=Cart_model::where('session_id',$session_id)->get();
        $total_price=0;
        foreach ($cart_datas as $cart_data){
            $total_price+=$cart_data->price*$cart_data->quantity;
        }
        
        //
        
         
        return view('frontEnd.cart',compact('cart_datas','total_price','shipments','countries','user_login'));
    }

    public function addToCart(Request $request){
        $inputToCart=$request->all();
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        if($inputToCart['size']==""){
            return back()->with('message','Please select Size');
            
        }
        elseif($inputToCart['color']==""){
            return back()->with('message','Please select Color');}
            elseif($inputToCart['material']==""){
                return back()->with('message','Please select Material');}
        else{
            $stockAvailable=DB::table('product_att')->select('stock','sku')->where(['products_id'=>$inputToCart['products_id'],
                'price'=>$inputToCart['price']])->first();
            
                $inputToCart['user_email']='user_email';
                $session_id=Session::get('session_id');
                if(empty($session_id)){
                    $session_id=str_random(40);
                    Session::put('session_id',$session_id);
                }
                $inputToCart['session_id']=$session_id;
                $sizeAtrr=explode("-",$inputToCart['size']);
                $inputToCart['size']=$sizeAtrr[1];
                $inputToCart['product_code']=$stockAvailable->sku;
                $count_duplicateItems=Cart_model::where(['products_id'=>$inputToCart['products_id'],
                    'product_color'=>$inputToCart['product_color'],
                    'size'=>$inputToCart['size']])->count();
                if($count_duplicateItems>0){
                    return back()->with('message','This Item Added already');
                }else{
                    Cart_model::create($inputToCart);
                    return back()->with('message','Add To Cart Already');
                }
            
        }
    }
    public function deleteItem($id=null){
        $delete_item=Cart_model::findOrFail($id);
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $delete_item->delete();
        return back()->with('message','Deleted Success!');
    }
    public function updateQuantity($id,$quantity){
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $sku_size=DB::table('cart')->select('product_code','size','quantity')->where('id',$id)->first();
        $stockAvailable=DB::table('product_att')->select('stock')->where(['sku'=>$sku_size->product_code,
            'size'=>$sku_size->size])->first();
        $updated_quantity=$sku_size->quantity+$quantity;
        if($stockAvailable->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
            return back()->with('message','Update Quantity already');
        }else{
            return back()->with('message','Stock is not Available!');
        }


    }
    public function submitcheckout(Request $request){
        $this->validate($request,[
            'billing_company'=>'required',
            'billing_street1'=>'required',
            'billing_city'=>'`required',
            'billing_state'=>'required',
            'billing_zip'=>'required',
            'billing_phone'=>'req`uired',
            'shipping_company'=>'required',
            'shipping_street1'=>'required',
            'shipping_city'=>'required',
            'shipping_state'=>'required',
            'shipping_zip'=>'required',
            'shipping_phone'=>'required',
            'shipping_phone'=>'quantity',
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
