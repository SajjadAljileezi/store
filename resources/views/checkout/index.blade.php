@extends('frontEnd.layouts.master')
@section('title','checkOut Page')
@section('slider')
@endsection
@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                {{Session::get('message')}}
            </div>
        @endif
        <div class="row">
            <form action="{{url('/submit-checkout')}}" method="post" class="form-horizontal">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <legend>Billing To</legend>
                        <div class="form-group {{$errors->has('billing_name')?'has-error':''}}">
                            <input type="text" class="form-control" name="billing_company" id="billing_company" value="{{$user_login->company}}" placeholder="Billing Name">
                            <span class="text-danger">{{$errors->first('billing_company')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('billing_street1')?'has-error':''}}">
                            <input type="text" class="form-control" value="{{$user_login->setreet1}}" name="billing_street1" id="billing_street1" placeholder="Billing Address">
                            <span class="text-danger">{{$errors->first('billing_street1')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('billing_city')?'has-error':''}}">
                            <input type="text" class="form-control" name="billing_city" value="{{$user_login->city}}" id="billing_city" placeholder="Billing City">
                            <span class="text-danger">{{$errors->first('billing_city')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('billing_state')?'has-error':''}}">
                            <input type="text" class="form-control" name="billing_state" value="{{$user_login->state}}" id="billing_state" placeholder=" Billing State">
                            <span class="text-danger">{{$errors->first('billing_state')}}</span>
                        </div>
                        <div class="form-group">
                            <select name="billing_country" id="billing_country" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}" {{$user_login->country==$country->country_name?' selected':''}}>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group {{$errors->has('billing_zip')?'has-error':''}}">
                            <input type="text" class="form-control" name="billing_zip" value="{{$user_login->zip}}" id="billing_zip" placeholder=" Billing Zip">
                            <span class="text-danger">{{$errors->first('billing_zip')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('billing_phone')?'has-error':''}}">
                            <input type="text" class="form-control" name="billing_phone" value="{{$user_login->phone}}" id="billing_phone" placeholder="Billing Phone">
                            <span class="text-danger">{{$errors->first('billing_phone')}}</span>
                        </div>

                        <span>
                            <input type="checkbox" class="checkbox" name="checkme" id="checkme">Shipping Address same as Billing Address
                        </span>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">

                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <legend>Shipping To</legend>
                        <div class="form-group {{$errors->has('shipping_company')?'has-error':''}}">
                            <input type="text" class="form-control" name="shipping_company" id="shipping_company" value="" placeholder="Shipping Name">
                            <span class="text-danger">{{$errors->first('shipping_company')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('shipping_street1')?'has-error':''}}">
                            <input type="text" class="form-control" value="" name="shipping_street1" id="shipping_street1" placeholder="Shipping Address">
                            <span class="text-danger">{{$errors->first('shipping_street1')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('shipping_city')?'has-error':''}}">
                            <input type="text" class="form-control" name="shipping_city" value="" id="shipping_city" placeholder="Shipping City">
                            <span class="text-danger">{{$errors->first('shipping_city')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('shipping_state')?'has-error':''}}">
                            <input type="text" class="form-control" name="shipping_state" value="" id="shipping_state" placeholder="Shipping State">
                            <span class="text-danger">{{$errors->first('shipping_state')}}</span>
                        </div>
                        <div class="form-group">
                            <select name="shipping_country" id="shipping_country" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}">{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group {{$errors->has('shipping_zip')?'has-error':''}}">
                            <input type="text" class="form-control" name="shipping_zip" value="" id="shipping_zip" placeholder="Shipping Zip">
                            <span class="text-danger">{{$errors->first('shipping_zip')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('shipping_phone')?'has-error':''}}">
                            <input type="text" class="form-control" name="shipping_phone" value="" id="shipping_phone" placeholder="Shipping Phone">
                            <span class="text-danger">{{$errors->first('shipping_phone')}}</span>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right;">CheckOut</button>
                    </div><!--/sign up form-->
                </div>
            </form>
        </div>
    </div>
    <div style="margin-bottom: 20px;"></div>
@endsection