<h1 style="margin-left:5%">{{$title}}</h1><br>
<nav>
  <div class="div-nav-tabs">
    <ul class="nav nav-tabs">
      @php
      $pageMap[1]=array(
      'name' => '首頁',
      'page' => 'HomeController.home',
      );
      $pageMap[2]=array(
      'name' => '最新動態',
      'page' => 'HomeController.news',
      );
      $pageMap[3]=array(
      'name' => 'TOP 10 人氣餐廳',
      'page' => 'HomeController.rank',
      );
      $pageMap[4]=array(
      'name' => '美食達人',
      'page' => 'HomeController.master',
      );
      @endphp

      @for($id=1; $id <= 4 ; $id++) @if($id==$page_id) <a class="nav-link active" aria-current="page">
        {{$pageMap[$id]['name']}}</a>
        </li>
        @else
        <a class="nav-link" href="{{route($pageMap[$id]['page'])}}">{{$pageMap[$id]['name']}}</a>
        </li>
        @endif
        @endfor
    </ul>
  </div>
</nav>
<br>