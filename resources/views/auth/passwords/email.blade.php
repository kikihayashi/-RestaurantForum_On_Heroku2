@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('找回密碼') }}</div>

        <div class="card-body">
          <p style="color:red">{{session('message')}}</p>
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <form method="POST" action="{{route('PasswordController.password')}}">
            @csrf

            <div class="form-group row">
              <label for="account" class="col-md-4 col-form-label text-md-right">{{ __('請輸入帳號') }}</label>

              <div class="col-md-6">
                <input id="account" type="account" class="form-control @error('account') is-invalid @enderror"
                  name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('請輸入信箱') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" required autocomplete="email" autofocus>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('送出') }}
                </button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection