@extends('layouts.app')
@section('content')

<section style="margin-left:10%;margin-right:10%">
  <h1>餐廳後台</h1>

  <a class="btn btn-primary" href="{{route('UserInfoController.createRestaurant')}}">新增餐廳</a>
  <br><br>
  <div>
    <a href="{{route('UserInfoController.showRestaurant')}}">所有餐廳</a> |
    <a href="{{route('UserInfoController.showCategory')}}">餐廳種類</a>
  </div>
  <br>
</section>

@if(isset($allRestaurants) && count($allRestaurants) > 0)
<section style="margin-left:10%;margin-right:10%">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>餐廳種類</th>
        <th>餐廳名稱</th>
      </tr>
    </thead>
    <tbody>
      @foreach($allRestaurants as $restaurant)
      <tr>
        <th scope="row">{{$restaurant->id}}</th>
        <td>{{$restaurant->category_name}}</td>
        <td>{{$restaurant->name}}</td>
      </tr>

      <tr>
        <td>
          <a class="btn btn-success btn-flat"
            href="{{route('UserInfoController.readRestaurant',$restaurant->id)}}">資訊</a>
          <a class="btn btn-primary btn-flat"
            href="{{route('UserInfoController.updateRestaurant', $restaurant -> id)}}">編輯</a>

          <a class="btn btn-danger btn-flat" onclick="
                if (confirm('確定要刪除' + '{{$restaurant -> name}}?')) {
                  document.getElementById('formDeleteRestaurant-{{ $restaurant->id }}').submit();
                  }">刪除</a>

          <form method="POST" style="display: none;"
            action="{{route('UserInfoController.deleteRestaurant',$restaurant -> id)}}"
            id="formDeleteRestaurant-{{ $restaurant->id }}">
            @csrf
            @method('DELETE')
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <br>
</section>

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">

    @if($allRestaurants->currentPage()!=1)
    <li class="page-item">
      <a class="page-link" href="{{$allRestaurants->url(1)}}" aria-label="First">
        <span aria-hidden="true">&laquo; First</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="{{$allRestaurants->previousPageUrl()}}" aria-label="Previous">
        <span aria-hidden="true">&lsaquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    @endif

    @for($i = 1; $i <= $allRestaurants->lastPage(); $i++)
      @if($i==$allRestaurants->currentPage())
      <li class="page-item active">
        <a class="page-link" href="{{$allRestaurants->url($i)}}">{{$i}}</a>
      </li>
      @else
      <li class="page-item">
        <a class="page-link" href="{{$allRestaurants->url($i)}}">{{$i}}</a>
      </li>
      @endif

      @endfor

      @if($allRestaurants->currentPage()!=$allRestaurants->lastPage())
      <li class="page-item">
        <a class="page-link" href="{{$allRestaurants->nextPageUrl()}}" aria-label="Next">
          <span aria-hidden="true">&rsaquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="{{$allRestaurants->url($allRestaurants->lastPage())}}" aria-label="Last">
          <span aria-hidden="true">Last &raquo;</span>
          <span class="sr-only">Last</span>
        </a>
      </li>
      @endif

  </ul>
</nav>

@endif

@endsection