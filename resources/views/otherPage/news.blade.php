@extends('layouts.app')
@section('content')

@include('layouts.navigation',
['page_id' => "2",'title'=>"餐廳最新動態"])

<section class="container">
  <div class="row">
    <hr>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-white bg-dark mb-3">最新餐廳</div>
        <div class="card-body">
          @foreach($allRestaurants as $thisRestaurant)
          <h4 class="card-title">
            <a class="card-title"
              href="{{route('RestaurantController.restaurant',$thisRestaurant->id)}}">{{$thisRestaurant->name}}</a>
            <small style="font-size:15px">({{$thisRestaurant->category_name}})</small>
          </h4>
          <p class="card-text" style="font-size:10px">{{$thisRestaurant->content}}</p>
          <hr>
          @endforeach
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-white bg-dark mb-3">最新評論</div>
        <div class="card-body">
          @foreach($allComments as $thisComment)
          <div>
            <h4>
              <a
                href="{{route('RestaurantController.restaurant',$thisComment->restaurant_id)}}">{{$thisComment->restaurant_name}}</a>
            </h4>
            <h5 style="color:green">{{$thisComment->comment}}</h5>
            <p style="margin-left:45%">
              {{$thisComment->updated_at}} -by
              <a href="{{route('UserInfoController.user',$thisComment->user_id)}}">{{$thisComment->user_name}}</a>
            </p>
            <hr>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

@endsection