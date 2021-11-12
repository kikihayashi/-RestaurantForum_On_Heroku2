@extends('layouts.app')
@section('content')

@include('layouts.navigation',
['page_id' => "3",'title'=>"TOP 10 人氣餐廳"])

<section style="margin-left:5%">
  @foreach($allRestaurants as $thisRestaurant)
  <div class="row">
    <div>
      <img style="height:100%" src="http://lorempixel.com/100/100/food/{{$thisRestaurant['id']%10}}" alt="圖片已失效" />
    </div>
    <div style="margin-left:3%;">
      <p>
      <h4><a href="{{route('RestaurantController.restaurant',$thisRestaurant['id'])}}">{{$thisRestaurant['name']}}</a>
        <small>{{$thisRestaurant['categoryName']}}</small>
        收藏數：{{$thisRestaurant['favoriteNumber']}}
      </h4>
      {{$thisRestaurant['content']}}
      </p>
      <!-- 這裡是加到最愛和按讚的模板 -->
      @include('layouts.favorite_and_like',
      ['page'=>"rank",
      'nowStatus'=> $allNowStatus[$thisRestaurant['id']] ?? null,
      'restaurantId'=> $thisRestaurant['id'],
      'paginate'=>0,
      'categoryId'=>0])
    </div>

  </div>
  <hr>
  @endforeach
</section>
@endsection