@extends('frontEnd.layouts.master')
@section('title','Review Order Page')
@section('slider')
@endsection
@section('content')
@section('assets')
    <link rel="stylesheet" href="frontEnd/css/stripe.css">
@endsection
    <div class="container">
        <div class="step-one">
            <h2 class="heading">Shipping To</h2>
        </div>
        <div class="row">
            <form action="{{url('/submit-order')}}" method="post" class="form-horizontal">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <input type="hidden" name="users_id" value="{{$shipping_street1->users_id}}">
                <input type="hidden" name="users_email" value="{{$shipping_street1->users_email}}">
                <input type="hidden" name="company" value="{{$shipping_street1->company}}">
                <input type="hidden" name="street1" value="{{$shipping_street1->street1}}">
                <input type="hidden" name="city" value="{{$shipping_street1->city}}">
                <input type="hidden" name="state" value="{{$shipping_street1->state}}">
                <input type="hidden" name="zip" value="{{$shipping_street1->zip}}">
                <input type="hidden" name="country" value="{{$shipping_street1->country}}">
                <input type="hidden" name="phone" value="{{$shipping_street1->phone}}">
                @foreach($cart_datas as $cart_data)
                <input type="hidden" name="quantities" value="{{$cart_data->quantity}}">
                @endforeach
                <input type="hidden" name="shipping_charges" value="0">
                <input type="hidden" name="order_status" value="success">

                @if(Session::has('discount_amount_price'))
                    <input type="hidden" name="coupon_code" value="{{Session::get('coupon_code')}}">
                    <input type="hidden" name="coupon_amount" value="{{Session::get('discount_amount_price')}}">
                    <input type="hidden" name="grand_total" value="{{$total_price-Session::get('discount_amount_price')}}">
                @else
                    <input type="hidden" name="coupon_code" value="NO Coupon">
                    <input type="hidden" name="coupon_amount" value="0">
                    <input type="hidden" name="grand_total" value="{{$total_price}}">
                @endif

                @if (Auth::user())
    <div class="row">
    <div class="container mb-5">
    <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

   <!-- shiiping -->

   <div class="container">
@foreach($shipments->messages as $row)
@if($loop->first)


  <table class="table">
<thead class="thead-dark">
  <tr>
  <th scope="col">Address</th>
    <th scope="col">Services</th>
    <th scope="col">Carrier</th>
    <th scope="col">Rates</th>
    <th scope="col">Estimate Deliver Days</th>
  </tr>

</thead>
<tbody>
  <tr>

  <td>{{$shipments->to_address->company}}<br> {{$shipments->to_address->street1}}
  <br> {{$shipments->to_address->city}} {{$shipments->to_address->state}} {{$shipments->to_address->zip}}</td>

    <td>{{$row->service}}</td>
    <td>{{$row->carrier}}</td>
    <td>{{$row->rate}}</td>
    <td>{{$row->delivery_days}} </td>
  </tr>
  @endif
  @endforeach

</tbody>
</table>
</div>
    </div>
</div>
    </div>
    @endif
                    <section id="cart_items">
                        <div class="review-payment">
                            <h2>Review & Payment</h2>
                        </div>
                        <div class="table-responsive cart_info">
                            <table class="table table-condensed">
                                <thead>
                                <tr class="cart_menu">
                                    <td class="image">Item</td>
                                    <td class="description"></td>
                                    <td class="price">Price</td>
                                    <td class="quantity">Quantity</td>
                                    <td class="total">Total</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart_datas as $cart_data)
                                    <?php
                                    $image_products=DB::table('products')->select('image')->where('id',$cart_data->products_id)->get();
                                    ?>
                                    <tr>
                                    <td class="cart_product">
                                        @foreach($image_products as $image_product)
                                            <a href=""><img src="{{url('products/small',$image_product->image)}}" alt="" style="width: 100px;"></a>
                                        @endforeach
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="">{{$cart_data->product_name}}</a></h4>
                                        <p>{{$cart_data->product_code}} | {{$cart_data->size}}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>${{$cart_data->price}}</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <p>{{$cart_data->quantity}}</p>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">$ {{$cart_data->price*$cart_data->quantity}}</p>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td colspan="2">
                                        <table class="table table-condensed total-result">
                                            <tr>
                                                <td>Cart Sub Total</td>
                                                <td>$ {{$total_price}}</td>
                                            </tr>
                                            @if(Session::has('discount_amount_price'))
                                                <tr class="shipping-cost">
                                                    <td>Coupon Discount</td>
                                                    <td>$ {{Session::get('discount_amount_price')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><span>$ {{$total_price-Session::get('discount_amount_price')}}</span></td>
                                                </tr>
                                            @else
                                            @foreach($shipments->rates as $row)
                                            @if($loop->first)
                                            <tr>
                                                <td>Shipping</td>
                                                <td>$ {{$row->rate}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                                <tr>
                                                    <td>Total</td>
                                                    <td><span>$ {{$total_price}}</span></td>
                                                </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="payment-options">
                            <span>Pay With Visa Or PayPal : </span>
                            <br>
                            <span>
                            <label><input type="radio" name="payment_method" value="Paypal"> Paypal</label>
                        </span>
                        <script src="https://js.stripe.com/v3/"></script>

                        <form action="/charge" method="post" id="payment-form">
                          <div class="form-row">
                            <label for="card-element">
                              Credit or debit card
                            </label>
                            <div id="card-element">
                              <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                          </div>

                          <button>Submit Payment</button>
                        </form>
      </div>    <button type="submit" class="btn btn-primary" style="float: right;">Order Now</button>
                        </div>
                    </section>

                </div>
            </form>
        </div>
    </div>
    <div style="margin-bottom: 20px;"></div>

@endsection
