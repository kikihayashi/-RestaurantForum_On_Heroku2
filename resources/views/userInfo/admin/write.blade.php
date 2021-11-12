@extends('layouts.app')

@section('content')
<section style="margin-left:5%;">

  @if(isset($allCategories))
  <form name="form_restaurant" enctype="multipart/form-data" accept-charset="UTF-8" method="POST" action="{{route(isset($restaurant)?
  'UserInfoController.editRestaurant':
  'UserInfoController.addRestaurant',
  $restaurant -> id??0)}}">

    @csrf
    @method(isset($restaurant)? 'PUT' : 'POST')
    <label for="restaurant_category">目錄</label><br>
    <select name="category" id="category">
      @foreach($allCategories as $category)
      <div>
        @if(isset($restaurant))
        <div>
          @if($category->id == $restaurant->category_id)
          <option value="{{$category->id}}" selected="selected">{{$category->name}}</option>
          @else
          <option value="{{$category->id}}">{{$category->name}}</option>
          @endif
        </div>
        @else
        <div>
          <option value="{{$category->id}}">{{$category->name}}</option>
        </div>
        @endif
      </div>
      @endforeach
    </select><br>
    <br>
    <label for="restaurant_name">餐廳名稱</label><br>
    <input type="text" name="name" id="name" value="{{$restaurant->name ?? ''}}" required><br>
    <br>

    <label for="restaurant_tel">聯絡電話</label><br>
    <input type="tel" name="tel" id="tel" value="{{$restaurant->tel ?? ''}}" pattern="0{1}[1-9]{1}[0-9]{7,8}"
      minlength="9" maxlength="10" placeholder="手機或市話" required><br>
    <small>格式: 09XXXXXXXX 或 07XXXXXXX </small>
    <br>
    <br>
    <label for="restaurant_address">地址</label><br>
    <input type="text" name="address" id="address" value="{{$restaurant->address ?? ''}}" required><br>
    <br>
    <label for="restaurant_opening_hour">營業時間</label><br>
    <input type="time" name="opening_hour" id="opening_hour" value="{{$restaurant->opening_hour ?? ''}}" required><br>
    <small>格式: </small>
    <br>
    <br>
    <label for="restaurant_content">描述</label><br>
    <textarea name="content" id="content" required>{{$restaurant->content ?? ''}}</textarea><br>
    <br>
    <input type="submit" value="{{isset($restaurant)? '更新餐廳':'新增餐廳'}}" data-disable-with="Write Restaurant">
    &nbsp;&nbsp;

    <a href="javascript:history.back()">回上一頁</a>
  </form>
  @else
  <a style="color:red" href="{{route('UserInfoController.showCategory')}}"><strong>請先新增餐種類</strong></a>
  @endif
</section>
@endsection