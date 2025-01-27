@extends('frontEnd.layouts.master')
@section('title','My Account Page')
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
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <form action="{{url('/update-profile',$user_login->id)}}" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        {{method_field('PUT')}}
                        <legend>Account Profile</legend>
                        <div class="form-group {{$errors->has('company')?'has-error':''}}">
                            <input type="text" class="form-control" name="company" id="company" value="{{$user_login->company}}" placeholder="company">
                            <span class="text-danger">{{$errors->first('company')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('street1')?'has-error':''}}">
                            <input type="text" class="form-control" value="{{$user_login->street1}}" name="street1" id="street1" placeholder="Address">
                            <span class="text-danger">{{$errors->first('street1')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('city')?'has-error':''}}">
                            <input type="text" class="form-control" name="city" value="{{$user_login->city}}" id="city" placeholder="City">
                            <span class="text-danger">{{$errors->first('city')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('state')?'has-error':''}}">
                            <input type="text" class="form-control" name="state" value="{{$user_login->state}}" id="state" placeholder="State">
                            <span class="text-danger">{{$errors->first('state')}}</span>
                        </div>
                        <div class="form-group">
                            <select name="country" id="country" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}" {{$user_login->country==$country->country_name?' selected':''}}>{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group {{$errors->has('zip')?'has-error':''}}">
                            <input type="text" class="form-control" name="zip" value="{{$user_login->zip}}" id="zip" placeholder="Zip">
                            <span class="text-danger">{{$errors->first('zip')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('phone')?'has-error':''}}">
                            <input type="text" class="form-control" name="phone" value="{{$user_login->phone}}" id="phone" placeholder="Phone">
                            <span class="text-danger">{{$errors->first('phone')}}</span>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right;">Update Profile</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <form action="{{url('/update-password',$user_login->id)}}" method="post" class="form-horizontal">
                        <legend>Update New Password</legend>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        {{method_field('PUT')}}
                        <div class="form-group {{$errors->has('password')?'has-error':''}}">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Old Password">
                            @if(Session::has('oldpassword'))
                                <span class="text-danger">{{Session::get('oldpassword')}}</span>
                            @endif
                        </div>
                        <div class="form-group {{$errors->has('newPassword')?'has-error':''}}">
                            <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password">
                            <span class="text-danger">{{$errors->first('newPassword')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('newPassword_confirmation')?'has-error':''}}">
                            <input type="password" class="form-control" name="newPassword_confirmation" id="newPassword_confirmation" placeholder="Confirm Password">
                            <span class="text-danger">{{$errors->first('newPassword_confirmation')}}</span>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right;">Update Password</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
    <div style="margin-bottom: 20px;"></div>
@endsection