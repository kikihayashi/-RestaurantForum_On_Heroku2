@extends('layouts.app')

@section('content')
<section style="margin-left:5%">
  <form enctype="multipart/form-data" accept-charset="UTF-8" method="POST"
    action="{{route('UserInfoController.editIntroduction',$thisUser->id)}}">
    @csrf
    @method('PUT')
    <div class="field">
      <label for="user_name">名字</label><br>
      <input type="text" value="{{$thisUser->name}}" name="user[]" id="user_name">
    </div>

    <br>

    <div class="field">
      <label for="user_introduction">簡介(給其他人看的)</label><br>
      <input type="text" value="{{$thisUser->introduction}}" name="user[]" id="user_introduction">
    </div>

    <br>
    <div class="form-group">
      <label for="user_avatar">大頭照上傳</label>
      <input type="file" name="avatar" id="user_avatar">
    </div>

    <input class="btn btn-primary" type="submit" name="commit" value="更新" data-disable-with="Update">
  </form>
</section>
@endsection