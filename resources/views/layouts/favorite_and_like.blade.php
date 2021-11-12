 <!-- 這裡是加到最愛和按讚的模板 -->
 <a class="btn btn-{{(isset($nowStatus) && $nowStatus->is_favorite=='Y')?'primary':'secondary'}}"
   onclick="document.getElementById('favorite-{{$restaurantId}}').submit();">{{(isset($nowStatus) && $nowStatus->is_favorite=='Y')?'已加最愛':'加到最愛'}}
 </a>
 <!-- 如果有nowStatus，代表曾經按過最愛 -->
 <!-- 如果沒有nowStatus，代表是第一次按最愛 -->
 <form id="favorite-{{$restaurantId}}" style="display: none;" accept-charset="UTF-8" method="POST" action="{{route(isset($nowStatus)?
  'RestaurantController.updateFavoriteAndLike':
  'RestaurantController.writeFavoriteAndLike',
  ['id'=>$restaurantId,
  'pageType'=>$page,
  'paginate'=>$paginate,
  'categoryId'=>$categoryId])}}">
   @csrf
   @method(isset($nowStatus)?'PUT':'POST')
   <input type="hidden" value="Favorite" name="type">
 </form>

 <a class="btn btn-{{(isset($nowStatus) && $nowStatus->is_like=='Y')?'primary':'secondary'}}"
   onclick="document.getElementById('like-{{$restaurantId}}').submit();">{{(isset($nowStatus) && $nowStatus->is_like=='Y')?'已按讚':'按讚'}}
 </a>
 <!-- 如果有nowStatus，代表曾經按過讚 -->
 <!-- 如果沒有nowStatus，代表是第一次按讚 -->
 <form id="like-{{$restaurantId}}" style="display: none;" accept-charset="UTF-8" method="POST" action="{{route(isset($nowStatus)?
  'RestaurantController.updateFavoriteAndLike':
  'RestaurantController.writeFavoriteAndLike',
 ['id'=>$restaurantId,
 'pageType'=>$page,
 'paginate'=>$paginate,
 'categoryId'=>$categoryId])}}">
   @csrf
   @method(isset($nowStatus)?'PUT':'POST')
   <input type="hidden" value="Like" name="type">
 </form>