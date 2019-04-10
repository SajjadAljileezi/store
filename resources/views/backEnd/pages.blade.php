@extends('backEnd.layouts.master')
@section('title','Dashboard')
@section('content')

<h1 class=" justify-content-center">Orders</h1>
@foreach($who_buyings as $who_buying)
<table class="table table-hover pt-5">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Company</th>
      <th scope="col">Address</th>
      <th scope="col">Phone</th>
      <th scope="col">Quantity</th>
      <th scope="col">Payment</th>
      <th scope="col">Total</th>
      <th scope="col">Time</th>
      <th scope="col">Status</th>
      <th scope="col">Completed</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">{{$who_buying->id}}</th>
      <td>{{$who_buying->company}}</td>
      <td>{{$who_buying->street1}}<br>{{$who_buying->city}},{{$who_buying->state}}, {{$who_buying->zip}}</td>
      <td>{{$who_buying->phone}}</td>
      <td>{{$who_buying->quantities}}</td>
      <td>{{$who_buying->payment_method}}</td>
      <td>{{$who_buying->grand_total}}</td>
      <td>{{$who_buying->created_at}}</td>
      <td>{{$who_buying->order_status}}</td>
      <td><button type="submit" id="{{$who_buying->id}}" value="{{$who_buying->id}}" class="btn btn-success"><a href="{{ url('/admin/page/completed/'.$who_buying->id) }}">NO</a></button></td>
    </tr>
  </tbody>
</table>
@endforeach

@endsection
