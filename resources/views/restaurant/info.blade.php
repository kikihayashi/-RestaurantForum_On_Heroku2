@extends('layouts.app')

@section('content')
<section style="font-size:25px; margin-left:10%">
  <h1>{{$name}}的餐廳資訊：</h1>
  <p>這家餐廳</p>
  <ul>
    <li>有 {{$commentNumber}} 筆評論</li>
    <li>有 {{$likeNumber}} 個人按讚</li>
    <li>有 {{$favoriteNumber}} 個人加入最愛</li>
  </ul>
</section>
@endsection