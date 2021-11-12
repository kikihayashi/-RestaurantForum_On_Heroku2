<!-- 此layout是登入者和所選擇的人是不同人的情況 -->
<a class="btn btn-{{(isset($nowStatus) && $nowStatus->follow=='Y')?'success':'primary'}}"
  onclick="document.getElementById('follow-{{$thisUserId}}').submit();">{{(isset($nowStatus) && $nowStatus->follow == 'Y')?'✔ 追蹤':'追蹤他'}}</a>

<form id="follow-{{$thisUserId}}" style="display: none;" accept-charset="UTF-8" method="POST" action="{{route(isset($nowStatus)?
    'UserInfoController.updateFriendOrFollow':
    'UserInfoController.writeFriendOrFollow',
    ['id'=>$thisUserId,'type'=>$page])}}">
  @csrf
  @method(isset($nowStatus)?'PUT':'POST')
  <input type="hidden" value="Follow" name="type">
</form>

<a class="btn btn-{{(isset($nowStatus) && $nowStatus->friend=='Y')?'success':'primary'}}"
  onclick="document.getElementById('friend-{{$thisUserId}}').submit();">{{(isset($nowStatus) && $nowStatus->friend=='Y')?' ✔ 好友':' + 好友'}}</a>

<form id="friend-{{$thisUserId}}" style="display: none;" accept-charset="UTF-8" method="POST" action="{{route(isset($nowStatus)?
    'UserInfoController.updateFriendOrFollow':
    'UserInfoController.writeFriendOrFollow',
    ['id'=>$thisUserId,'type'=>$page])}}">
  @csrf
  @method(isset($nowStatus)?'PUT':'POST')
  <input type="hidden" value="Friend" name="type">
</form>