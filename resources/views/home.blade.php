@extends('layouts.app')
@section('content')

@include('layouts.navigation',
['page_id' => "1",'title'=>"餐廳介紹"])

<nav>
  <div class="div-nav-pills">
    <ul class="nav nav-pills nav-fill">
      <li class="nav-item">
        <a class="nav-link {{($categoryID > 0)?'':'active'}}" aria-current="page"
          href="{{route('HomeController.home')}}">全部餐廳</a>
      </li>

      @php
      $unCategorizedId;
      @endphp
      @foreach($allCategories as $category)
      @if($category->name !='未分類')

      @if($categoryID == $category->id)
      <li class="nav-item">
        <a class="nav-link active"
          href="{{route('RestaurantController.category',$category->id)}}">{{$category->name}}</a>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link" href="{{route('RestaurantController.category',$category->id)}}">{{$category->name}}</a>
      </li>
      @endif

      @else

      @php
      $unCategorizedId = $category->id;
      @endphp

      @endif
      @endforeach
      <li class="nav-item">
        <a class="nav-link {{($categoryID == $unCategorizedId)?'active':''}}" aria-current="page"
          href="{{route('RestaurantController.category',$unCategorizedId)}}">未分類</a>
      </li>
    </ul>
  </div>
</nav>

@if(count($thisTypeRestaurants) > 0)
<section class="container">
  <div class="row">
    @foreach($thisTypeRestaurants as $thisRestaurant)
    <div class="col-sm-6 col-md-4">
      <div class="div-restaurant-item">
        <img src="http://lorempixel.com/300/300/food/{{$thisRestaurant->id%10}}" alt="圖片已失效"><br>
        <div style="padding-left:5%; padding-right:5%;">
          <h3><a href="{{route('RestaurantController.restaurant',$thisRestaurant->id)}}">{{$thisRestaurant->name}}</a>
          </h3>
          <p class="badge badge-dark">
            <a style="color:white" href="{{route('RestaurantController.category',$thisRestaurant->category_id)}}">
              {{$thisRestaurant->category_name}}</a>
          </p>
          <p>{{$thisRestaurant->content}}</p>
          <!-- 這裡是加到最愛和按讚的模板 -->
          @include('layouts.favorite_and_like',
          ['page'=>"home",
          'nowStatus'=> $allNowStatus[$thisRestaurant->id] ?? null,
          'restaurantId'=> $thisRestaurant->id,
          'paginate'=>$thisTypeRestaurants->currentPage(),
          'categoryId'=>$categoryID])
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
<br>

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">

    @if($thisTypeRestaurants->currentPage()!=1)
    <li class="page-item">
      <a class="page-link" href="{{$thisTypeRestaurants->url(1)}}" aria-label="First">
        <span aria-hidden="true">&laquo; First</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="{{$thisTypeRestaurants->previousPageUrl()}}" aria-label="Previous">
        <span aria-hidden="true">&lsaquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    @endif

    @for($i = 1; $i <= $thisTypeRestaurants->lastPage(); $i++)
      @if($i==$thisTypeRestaurants->currentPage())
      <li class="page-item active">
        <a class="page-link" href="{{$thisTypeRestaurants->url($i)}}">{{$i}}</a>
      </li>
      @else
      <li class="page-item">
        <a class="page-link" href="{{$thisTypeRestaurants->url($i)}}">{{$i}}</a>
      </li>
      @endif
      @endfor

      @if($thisTypeRestaurants->currentPage()!=$thisTypeRestaurants->lastPage())
      <li class="page-item">
        <a class="page-link" href="{{$thisTypeRestaurants->nextPageUrl()}}" aria-label="Next">
          <span aria-hidden="true">&rsaquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="{{$thisTypeRestaurants->url($thisTypeRestaurants->lastPage())}}" aria-label="Last">
          <span aria-hidden="true">Last &raquo;</span>
          <span class="sr-only">Last</span>
        </a>
      </li>
      @endif
  </ul>
</nav>

@else
<h3 style="color: red; text-align:center;">尚未有此種類餐廳！</h3>
@endif

<!-- <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          {{ __('已登入') }}
        </div>
      </div>
    </div>
  </div> -->
@endsection