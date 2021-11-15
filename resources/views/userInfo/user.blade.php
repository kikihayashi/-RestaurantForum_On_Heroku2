@extends('layouts.app')

@section('content')
<div class="container">
  <section>
    <div style="display:flex; flex-wrap: wrap;" class="card-body">
      <div class="div-img-user-avatar">
        <!-- 放圖片 -->
        @php
        if(File::exists('img/'.$thisUser->account.'.jpg')){
        $srcUrl="../../img/".$thisUser->account.".jpg";
        $altMsg="沒有大頭貼";
        } else {
        $srcUrl="https://lorempixel.com/400/200/cats/". ($thisUser->id%10);
        $altMsg="圖片已失效";
        }
        @endphp

        <img class="rounded" width="220px" height="200px" src={{$srcUrl}} alt={{$altMsg}}>

        <br>
      </div>

      <div>
        <h2>{{$thisUser->name}}</h2>
        <p><strong>{{$thisUser->email}}</strong></p>
        <ul class="ul-user">
          <li><strong>{{$allComment->count()}}</strong> 已評論餐廳 &nbsp;</li>
          <li><strong>{{$allFavorite->count()}}</strong> 收藏的餐廳 &nbsp;</li>
          <li> 追蹤 <strong>{{$allFollow->count()}}</strong> 人 &nbsp;</li>
          <br>
          <li><strong>{{$allFollower->count()}}</strong> 追蹤者 &nbsp;</li>
          <li><strong>{{$allFriend->count()}}</strong> 好友&nbsp;</li>
        </ul>
        <br>
        <p>
          {{($thisUser->id == Auth::user()->id)?'歡迎回來！'.$thisUser->name:$thisUser->introduction.'，我是 '.$thisUser->name.'！'}}
        </p>
        @if($thisUser->id == Auth::user()->id)
        <a class="btn btn-success" href="{{route('UserInfoController.introduction',$thisUser->id)}}">個人簡介</a>
        <a class="btn btn-success" href="{{route('UserInfoController.friend',$thisUser->id)}}">好友列表</a>
        @else
        <!-- 此layout是登入者和所選擇的人是不同人的情況 -->
        @include('layouts.friend_and_follow',
        ['thisUserId'=>$thisUser->id,
        'page'=>"user"])
        @endif
      </div>
    </div>

    <br>
    <hr>
  </section>
</div>

<nav>
  <h5 class="card-header" style="text-align:center">{{$allComment->count()}} 已評論餐廳</h5>
  <div class="card-group">
    <div class="card">
      <div style="display:flex; flex-wrap: wrap;" class="card-body">
        @foreach($allComment as $comment) <div class="div-img-user-restaurant">
          <a href="{{route('RestaurantController.restaurant',$comment->restaurant_id)}}">
            <div class="div-img-avatar">
              <img class="rounded mx-auto d-block"
                src="http://lorempixel.com/100/100/food/{{$comment->restaurant_id%10}}" alt="圖片已失效">
              <h5>{{$comment->restaurant_name}}</h5>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</nav>

<br>

<nav>
  <h5 class="card-header" style="text-align:center">{{$allFavorite->count()}} 收藏的餐廳</h5>
  <div class="card-group">
    <div class="card">
      <div style="display:flex; flex-wrap: wrap;" class="card-body">
        @foreach($allFavorite as $favorite) <div class="div-img-user-restaurant">
          <a href="{{route('RestaurantController.restaurant',$favorite->restaurant_id)}}">
            <div class="div-img-avatar">
              <img class="rounded mx-auto d-block"
                src="http://lorempixel.com/100/100/food/{{$favorite->restaurant_id%10}}" alt="圖片已失效">
              <h5>{{$favorite->restaurant_name}}</h5>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</nav>

<br>

<nav>
  <h5 class="card-header" style="text-align:center">{{$allFollow->count()}}追蹤</h5>
  <div class="card-group">
    <div class="card">
      <div style="display:flex; flex-wrap: wrap;" class="card-body">
        @foreach($allFollow as $follow) <div class="div-img-user-restaurant">
          <a href="{{route('UserInfoController.user',$follow->relation_user_id)}}">
            <div class="div-img-avatar">
              @if(File::exists('img/'.$follow->relationUserAccount.'.jpg'))
              <img class="rounded mx-auto d-block" src="../../img/{{$follow->relationUserAccount}}.jpg" alt="沒有大頭貼">
              @else
              <img class="rounded mx-auto d-block"
                src="https://lorempixel.com/400/200/cats/{{$follow->relation_user_id%10}}" alt="圖片已失效">
              @endif
              <h5>{{$follow->relationUser_name}}</h5>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</nav>

<br>

<nav>
  <h5 class="card-header" style="text-align:center">
    {{$allFollower->count()}}追蹤者</h5>
  <div class="card-group">
    <div class="card">
      <div style="display:flex; flex-wrap: wrap;" class="card-body">
        @foreach($allFollower as $follower) <div class="div-img-user-restaurant">
          <a href="{{route('UserInfoController.user',$follower->user_id)}}">
            <div class="div-img-avatar">

              @if(File::exists('img/'.$follower->relationUserAccount.'.jpg'))
              <img class="rounded mx-auto d-block" src="../../img/{{$follower->relationUserAccount}}.jpg" alt="沒有大頭貼">
              @else
              <img class="rounded mx-auto d-block" src="https://lorempixel.com/400/200/cats/{{$follower->user_id%10}}"
                alt="圖片已失效">
              @endif

              <h5>{{$follower->relationUser_name}}</h5>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</nav>
@endsection