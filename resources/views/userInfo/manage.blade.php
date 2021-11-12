@extends('layouts.app')

@section('content')

<div class="container">
  <section>
    <h1>修改個人資料</h1>

    <p style="color:red;"><strong>{{session('errorMessage')}}</strong></p>

    <form class="edit_user" id="edit_user" action="{{route('UserInfoController.writeAccount')}}" accept-charset="UTF-8"
      method="POST">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="user_name">你的姓名：</label>
        <input autocomplete="on" type="text" value="{{$user->name}}" name="user[new_name]" id="user_name" required />
      </div>

      <div class="field">
        <label for="user_email">你的信箱：</label>
        <input autocomplete="on" type="email" value="{{$user->email}}" name="user[new_email]" id="user_email"
          required />
      </div>

      <div class="field">
        <label for="user_current_password">目前密碼：</label>
        <input autocomplete="off" type="password" name="user[password]" id="user_current_password" required />
      </div>

      <div class="field">
        <label for="user_password">新密碼(未修改可不填)：</label>
        <input autocomplete="off" type="password" placeholder="至少6個字元" name="user[new_password]" id="user_password" />
        <br />
      </div>

      <div class="field">
        <label for="user_password_confirmation">再次輸入新密碼：</label>
        <input autocomplete="off" type="password" placeholder="至少6個字元" name="user[new_password_confirmation]"
          id="user_password_confirmation" />
      </div>

      <br>
      <div class="actions">
        <input class="btn btn-success btn-flat" type="submit" name="commit" value="修改"
          data-disable-with="Update" />&nbsp;
        <a href="javascript:history.back()">回上一頁</a>
      </div>
    </form>
  </section>

  <hr>
  <section>
    <h3>停用帳號</h3>

    <a class="btn btn-danger btn-flat" onclick="
                if (confirm('確定要停用帳號嗎？帳號將不可復原！')) {
                  document.getElementById('deleteAccount').submit();
                  }">停用</a>

    <form id="deleteAccount" method="POST" action="{{route('UserInfoController.deleteAccount')}}">
      @csrf
      @method('DELETE')
    </form>
  </section>

</div>
@endsection