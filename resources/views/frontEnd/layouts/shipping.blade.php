@extends('frontEnd.layouts.master')
@section('title','Cart Page')
@section('slider')
@endsection
@section('content')
<div class="container">

  @foreach($shipments->rates as $row) 
  


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
    @endforeach
    
  </tbody>
</table>  
<h1> Other Shiping Options</h1>
<table class="table">
  <thead class="thead-light">
  @foreach($shipments->messages as $mes) 
    <tr>
      <th scope="col">carrier</th>
      <th scope="col">type</th>
      <th scope="col">message</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      
      <td>{{$mes->carrier}}</td>
      <td>{{$mes->type}}</td>
      <td>{{$mes->message}}</td>
    </tr>
  
  </tbody>
</table>
@endforeach
</div>
@endsection