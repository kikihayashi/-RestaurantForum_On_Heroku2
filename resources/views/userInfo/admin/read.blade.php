@extends('layouts.app')

@section('content')
<section style="margin-left:5%;">
  <h1>{{$thisRestaurant->name}}</h1>
  營業時間:{{$thisRestaurant->opening_hour}}<br>
  電話: {{$thisRestaurant->tel}}<br>
  地址: {{$thisRestaurant->address}}<br>
  描述:{{$thisRestaurant->content}}<br>
  種類：{{$thisRestaurant->categoryName}}<br>
  <a href="{{route('UserInfoController.showRestaurant')}}">回到所有餐廳</a>
</section>

@endsection