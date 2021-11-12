@extends('layouts.app')

@section('content')
<section style="margin-left:10%;margin-right:10%">
  <h1>餐廳後台</h1>

  <form class="domain-form" method="POST" action="{{route('UserInfoController.addCategory')}}">
    @csrf
    <div class="form-group d-md-flex">
      <input id="categoryName" name="categoryName" style="width:200px;" class="form-control" placeholder="新增餐廳種類"
        type="text" required>&nbsp;&nbsp;
      <input class="btn btn-primary" type="submit" value="新增種類">
    </div>
  </form>

  <!-- 因為有加required，所以這行用不到了，詳情可查看UserInfoController.addCategory-->
  <p style="color:red;"><strong>{{session('errorMessage')}}</strong></p>

  <div>
    <a href="{{route('UserInfoController.showRestaurant')}}">所有餐廳</a> |
    <a href="{{route('UserInfoController.showCategory')}}">餐廳種類</a>
  </div>
  <br>
</section>

@if(isset($allCategories) && count($allCategories) > 0)
<section style="margin-left:10%;margin-right:10%">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>種類</th>
            <th>設定</th>
          </tr>
        </thead>
        <tbody>
          @foreach($allCategories as $category) <tr>
            @if($category -> name != '未分類')
            <th scope="row">{{$category -> id}}</th>
            <td>{{$category -> name}}</td>
            <td>
              <a class="btn btn-primary btn-flat" onclick="
                var newName = prompt('請修改餐廳種類', '{{$category -> name}}');
                if (newName =='') {
                  alert(' 請輸入餐廳種類');
                  return;
                } else if(newName == null || newName == '{{$category -> name}}'){
                  return;
                } else {
                  //id結尾之所以設計有'-{{ $category->id }}'，是因為這裡是由迴圈組成，所以必須要區別項目的id
                  //這個是底下input的id，將newName設置到value
                  document.getElementById('categoryName-{{ $category->id }}').value = newName;
                  //這個是底下form的id
                  document.getElementById('formEditCategory-{{ $category->id }}').submit();
                }">修改</a>

              <form id="formEditCategory-{{ $category->id }}" style="display: none;" method="POST"
                action=" {{route('UserInfoController.editCategory')}}">
                {{csrf_field()}}
                <!-- 更新要用PUT -->
                {{ method_field('PUT') }}
                <input type="hidden" value="{{ $category -> id }}" name="category[]">
                <input type="hidden" id="categoryName-{{ $category->id }}" name="category[]">
              </form>

              <a class="btn btn-danger btn-flat" onclick="
                if (confirm('確定要刪除' + '{{$category -> name}}?')) {
                  document.getElementById('formDeleteCategory-{{ $category->id }}').submit();
                  }">刪除</a>

              <form id="formDeleteCategory-{{ $category->id }}" style="display: none;" method="POST"
                action="{{route('UserInfoController.deleteCategory',$category -> id)}}">
                {{csrf_field()}}
                <!-- 刪除要用DELETE -->
                {{ method_field('DELETE') }}
                <input type="hidden" value="{{ $category -> id }}" name="categoryID">
              </form>
            </td>
          </tr>
          @endif
          @endforeach

        </tbody>
      </table>
    </div>
  </div>
</section>
@endif
@endsection