@extends('layouts.app')
<img style="position:fixed;top:0;width:100%;" src="../../img/bg1.jpg" alt="圖片已失效">
@section('content')
<!-- <div class="row justify-content-start"> -->
<div class="justify-content-start">

  <!-- <div class="col-md-3" style="margin-left:3%"> -->
  <div style="margin-left:3%">

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div>
        <label><strong>帳號</strong></label>
        <input id="account" type="text" style="width:20%"
          class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account"
          value="{{ old('account') }}" required>

        @error('account')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <br>
      <div>
        <label><strong>密碼</strong></label>
        <div>
          <input id="password" type="password" style="width:20%"
            class="form-control @error('password') is-invalid @enderror" name="password" required>

          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror

        </div>
      </div>

      <!-- <div class="form-group row">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                  <label class="form-check-label" for="remember">
                    {{ __('記住我') }}
                  </label>
                </div>
              </div>
            </div> -->

      <br>
      <div>
        <div>
          <button type="submit" class="btn btn-dark">
            {{ __('登入') }}
          </button>

          @if (Route::has('password.request'))
          <a style="color:black" class="btn btn-link" href="{{ route('password.request') }}">
            <strong>{{ __('忘記密碼?') }}</strong>
          </a>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
@endsection