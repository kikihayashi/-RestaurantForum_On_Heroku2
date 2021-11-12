@extends('layouts.app')

@section('content')
<div class="container">

  <section style="margin-left:2%">
    <div class="row">

      <div class="col-md-12">
        <h1>{{$thisRestaurant->name}}</h1>
        <p>{{$thisRestaurant->categoryName}}</p>
      </div>

      <div class="col-md-4">
        <div class="div-ul-comment rounded border border-2">
          <ul class="list-style-type:none;">
            <li><strong>營業時間:</strong>
              {{$thisRestaurant->opening_hour}}</li>
            <li><strong>電話:</strong> {{$thisRestaurant->tel}}</li>
            <li><strong>地址:</strong> {{$thisRestaurant->address}}</li>
          </ul>
        </div>
      </div>

      <div class="col-md-8">
        <p>{{$thisRestaurant->content}}</p> <br>
        <a class="btn btn-success" href="{{route('RestaurantController.info',$thisRestaurant->id)}}">餐廳資訊</a>
        <!-- 這裡是加到最愛和按讚的模板 -->
        @include('layouts.favorite_and_like',
        ['page'=>"restaurant",
        'restaurantId'=> $thisRestaurant->id,
        'paginate'=>0,
        'categoryId'=>0])
        <hr>
      </div>
    </div>
  </section>

  @if(isset($allComment) && count($allComment) > 0)
  @foreach($allComment as $comment)
  <section style="margin-left:2%">
    <h4><a href="{{route('UserInfoController.user',$comment->user_id)}}">{{$comment->userName}}</a></h4>
    <p></p>
    <p>{{$comment->comment}}</p>
    <p></p>
    <p class="text-muted">
      <em>{{$comment->updated_at}}</em>
    </p>

    @if(Auth::user()->is_admin==1 ||
    !strcmp($comment->user_id, Auth::user()->id))
    <a class="btn btn-danger btn-flat" onclick="
                if (confirm('確定要刪除評論？')) {
                  document.getElementById('formDeleteCategory-{{ $comment->id }}').submit();
                  }">刪除評論</a>

    <form id="formDeleteCategory-{{ $comment->id }}" style="display: none;" accept-charset="UTF-8" method="POST"
      action="{{route('RestaurantController.deleteComment', $thisRestaurant->id)}}">
      @csrf
      <!-- 刪除要用DELETE -->
      @method('DELETE')
      <input type="hidden" value="{{ $comment -> id }}" name="commentID">
    </form>
    @endif

    <hr>
  </section>
  @endforeach
  @endif

  <section>
    <div class="container">
      <form accept-charset="UTF-8" method="POST"
        action="{{route('RestaurantController.comment', $thisRestaurant->id)}}">
        @csrf
        @method('POST')
        <div class="form-group">
          <textarea placeholder="留個言吧" class="form-control" name="message" id="message"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="commit" value="評論" class="btn btn-primary" data-disable-with="Create Comment">
          <button name="button" type="reset" class="btn btn-secondary">清除</button>
        </div>
      </form>
    </div>
  </section>

</div>
@endsection