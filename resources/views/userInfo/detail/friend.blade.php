@extends('layouts.app')

@section('content')

@if(isset($allFriends) && count($allFriends) > 0)
<h1 style="margin-left:5%">好友名單</h1>
<br>
<nav>
  <div class="row">
    @foreach($allFriends as $friend) <div class="col-md-3 col-sm-4 col-xs-6 text-center user-item">
      <a href="{{route('UserInfoController.user',$friend->relation_user_id)}}">
        <!-- 放圖片 -->
        @php
        if((File::exists('img/'.$friend->relationUserAccount.'.jpg'))){
        $srcUrl="../../../img/".$friend->relationUserAccount.".jpg";
        $altMsg="沒有大頭貼";
        } else {
        $srcUrl="https://lorempixel.com/400/200/cats/. "($friend->relation_user_id%10);
        $altMsg="圖片已失效";
        }
        @endphp

        <img class="rounded" style="width: 140px;height:128px;" src={{$srcUrl}} alt={{$altMsg}}>

        <br><br>
        <h4>{{$friend->relationUser_name}}</h4>
      </a>
      <br>
    </div>
    @endforeach
  </div>
</nav>
@else
<h1 style="margin-left:5%">暫無好友</h1>
@endif
@endsection