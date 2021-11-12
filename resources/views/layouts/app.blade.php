<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
  <title>餐廳評論網</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- 引用css資料夾的main.css -->
  <link href="/css/main.css" rel="stylesheet">
</head>

<body>

  <div id="page-container">
    <div id="content-wrap">
      <nav class="navbar navbar-expand-md navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">
            餐廳評論網
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
              @if (Route::has('login'))
              <li class="nav-item">
                <a class="nav-link" onMouseOver="this.style.color='#F0F11C'" onMouseOut="this.style.color='#9A9DA0'"
                  href="{{ route('login') }}">{{ __('登入') }}</a>
              </li>
              @endif

              @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" onMouseOver="this.style.color='#F0F11C'" onMouseOut="this.style.color='#9A9DA0'"
                  href="{{ route('register') }}">{{ __('註冊') }}</a>
              </li>
              @endif
              @else

              @if(Auth::user()->is_admin==1)
              <li class="nav-item dropdown">
                <a class="nav-link" onMouseOver="this.style.color='#F0F11C'" onMouseOut="this.style.color='#9A9DA0'"
                  href="{{route('UserInfoController.showRestaurant')}}">
                  {{ __('管理員後台') }}</a>
              </li>
              @endif

              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link" onMouseOver="this.style.color='#F0F11C'"
                  onMouseOut="this.style.color='#9A9DA0'" aria-haspopup="true" aria-expanded="false" v-pre
                  href="{{route('UserInfoController.user',Auth::user())}}">
                  你好,{{ Auth::user()->name}}
                </a>
              </li>

              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link" onMouseOver="this.style.color='#F0F11C'"
                  onMouseOut="this.style.color='#9A9DA0'" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('登出') }}
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </a>

                <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('登出') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div> -->
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link" onMouseOver="this.style.color='#F0F11C'" onMouseOut="this.style.color='#9A9DA0'"
                  href="{{route('UserInfoController.manage')}}">{{ __('帳號設定') }}</a>
              </li>

              @endguest
            </ul>
          </div>
        </div>
      </nav>

      <!-- 如果有session資訊，就顯示出來 -->
      @if(session()->has('message'))
      <br>
      <div style="margin-left:10%;margin-right:10%">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
              aria-hidden="true">×</span></button>
          {{session('message')}}
        </div>
      </div>
      @endif

      <main class="py-4">
        @yield('content')
      </main>
    </div>

    <script src="/js/index.js"></script>
    <!-- 放一些版權聲明 -->

    <br><br>
    <footer id="footer">
      Copyright 2021 Woody Production
    </footer>
  </div>
</body>

</html>