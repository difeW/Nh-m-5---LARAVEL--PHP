@extends('layout')
@section('content')

<div class="container">
    <h2 class="title text-center">Chọn Địa Chỉ</h2>
    <div class="row infoAddr">
        @foreach($shipping as $key => $ship)
        <div style="border: 1px solid var(--saphire-blue); margin:10px; border-radius: 10px;" class="col-md-4">
            <div class="text-right">
                <a href="{{URL::to('/delete-shipping/'.$ship->shipping_id)}}" style="border: 1px outset; padding:5px;" class=" text-right">X</a>
            </div>
            <a href="{{URL::to('/payment/'.$ship->shipping_id)}}" class="clearfix" style="padding: 5px; color: black;">
                <p><b>Tên:</b> {{$ship->shipping_name}}</p>
                <p><b>Địa chỉ:</b> {{$ship->shipping_address}}</p>
                <p><b>Số điện thoại:</b> {{$ship->shipping_phone}}</p>
            </a>
        </div>
        @endforeach
    </div>
    <div class="text-center" style="margin-bottom: 2rem;">
        <a class="btn btn-default" href="{{URL::to('/checkout')}}">Thêm địa chỉ</a>
    </div>
</div>

@endsection