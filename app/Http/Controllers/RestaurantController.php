<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    //加入顯示頁(針對傳入種類id資料庫顯示第幾筆資料)
    public function category($category_id)
    {
        $categories = Category::orderBy('id', 'ASC')->get();
        $restaurants = Restaurant::where('category_id', $category_id)
            ->join('categories', 'restaurants.category_id', '=', 'categories.id')
            ->selectRaw('restaurants.* , categories.name AS categoryName')
            ->paginate(6);

        $statusCollection = Favorite::where('user_id', Auth::id())
            ->get();

        $statusNew = array();
        foreach ($statusCollection as $status) {
            //注意這裡關聯性，這裡是以餐廳(restaurant_id)當作key值
            $statusNew[$status->restaurant_id] = $status;
        }

        return view('home', [
            'categoryID' => $category_id,
            'thisTypeRestaurants' => $restaurants,
            'allCategories' => $categories,
            'allNowStatus' => $statusNew]);
    }

    //顯示單一餐廳頁面
    public function restaurant($restaurant_id)
    {
        $restaurant = Restaurant::where('restaurants.id', $restaurant_id)
            ->join('categories', 'restaurants.category_id', '=', 'categories.id')
            ->selectRaw('restaurants.* , categories.name AS categoryName')
            ->firstOrFail();

        $comments = Comment::where('restaurant_id', $restaurant_id)
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->selectRaw('comments.* , users.name AS userName')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $status = Favorite::where('user_id', Auth::id())
            ->where('restaurant_id', $restaurant_id)
            ->selectRaw('favorites.is_favorite , favorites.is_like')
            ->first();

        return view('restaurant.comment',
            ['thisRestaurant' => $restaurant,
                'allComment' => $comments,
                'nowStatus' => $status]);
    }

    //餐廳資訊頁面
    public function info($restaurant_id)
    {
        $restaurantName = Restaurant::where('id', $restaurant_id)->firstOrFail()()->name;
        $comment = Comment::where('restaurant_id', $restaurant_id)->get();
        $favorite = Favorite::where('restaurant_id', $restaurant_id)
            ->where('is_favorite', 'Y')->get();
        $like = Favorite::where('restaurant_id', $restaurant_id)
            ->where('is_like', 'Y')->get();

        $commentCount = empty($comment) ? 0 : $comment->count();
        $favoriteCount = empty($favorite) ? 0 : $favorite->count();
        $likeCount = empty($like) ? 0 : $like->count();

        $array = [
            'name' => $restaurantName,
            'commentNumber' => $commentCount,
            'favoriteNumber' => $favoriteCount,
            'likeNumber' => $likeCount,
        ];

        return view('restaurant.info', $array);
    }

    //評論餐廳
    public function comment($restaurant_id)
    {
        $comments = new Comment();

        $comments->user_id = Auth::id();
        $comments->restaurant_id = $restaurant_id;
        $comments->comment = request('message');

        $comments->save();

        return redirect(route('RestaurantController.restaurant', $restaurant_id));
    }

    //刪除餐廳評論
    public function deleteComment($restaurant_id)
    {
        $id = request('commentID');

        $comment = Comment::findOrFail($id);

        $comment->delete();

        return redirect(route('RestaurantController.restaurant', $restaurant_id));
    }

    //第一次加入最愛or按讚
    public function writeFavoriteAndLike($id, $pageType, $categoryId, $paginate)
    {
        $favorite = new Favorite();
        $favorite->user_id = Auth::id();
        $favorite->restaurant_id = $id;

        $type = request('type');
        switch ($type) {
            case 'Favorite':
                $favorite->is_favorite = 'Y';
                $favorite->is_like = 'N';
                break;
            case 'Like':
                $favorite->is_favorite = 'N';
                $favorite->is_like = 'Y';
                break;
        }

        $favorite->save();

        switch ($pageType) {
            case 'restaurant':
                return redirect(route('RestaurantController.restaurant', $id));
            case 'home':
                if ($categoryId == 0) {
                    $url = route('HomeController.home');
                } else {
                    $url = route('RestaurantController.category', $categoryId);
                }
                return redirect($url . '?page=' . $paginate);
            case 'rank':
                return redirect(route('HomeController.rank'));
        }
    }

    //取消or加入最愛，按讚or退讚
    public function updateFavoriteAndLike($id, $pageType, $categoryId, $paginate)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('restaurant_id', $id)
            ->firstOrFail();

        $type = request('type');
        switch ($type) {
            case 'Favorite':
                if ($favorite->is_favorite == 'Y') {
                    $favorite->is_favorite = 'N';
                } else {
                    $favorite->is_favorite = 'Y';
                }
                break;

            case 'Like':
                if ($favorite->is_like == 'Y') {
                    $favorite->is_like = 'N';
                } else {
                    $favorite->is_like = 'Y';
                }
                break;
        }

        $favorite->save();

        switch ($pageType) {
            case 'restaurant':
                return redirect(route('RestaurantController.restaurant', $id));
            case 'home':
                if ($categoryId == 0) {
                    $url = route('HomeController.home');
                } else {
                    $url = route('RestaurantController.category', $categoryId);
                }
                return redirect($url . '?page=' . $paginate);
            case 'rank':
                return redirect(route('HomeController.rank'));
        }
    }
}