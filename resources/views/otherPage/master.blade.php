@extends('layouts.app')
@section('content')

@include('layouts.navigation',
['page_id' => "4",'title'=>"美食達人"])

<section class="container">
  <div class="row">
    @foreach($allRelations as $relation)
    <div style="text-align: center;" class="col-sm-6 col-md-3" style="border-style:solid; border-color:red;">
      <a href="{{route('UserInfoController.user',$relation->user_id)}}">

        @if(File::exists('img/'.$relation->user_account.'.jpg'))
        <img class="rounded" style="width: 140px;height:128px" src="../../img/{{$relation->userAccount}}.jpg"
          alt="沒有大頭貼">
        @else
        <img class="rounded" style="width: 140px;height:128px"
          src="https://lorempixel.com/400/200/cats/{{$relation->user_id%10}}" alt="圖片已失效">
        @endif

        <h4 style="text-align:center">{{$relation->user_name}}</h4>
      </a>
      <!-- 此layout是登入者和所選擇的人是不同人的情況 -->
      @include('layouts.friend_and_follow',
      ['thisUserId'=> $relation->user_id,
      'nowStatus'=> $allNowStatus[$relation->user_id] ?? null,
      'page'=> "master"])
    </div>

    @endforeach
  </div>
</section>
@endsection