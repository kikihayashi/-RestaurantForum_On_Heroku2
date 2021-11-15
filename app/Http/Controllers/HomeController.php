<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Relation;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //有用的話，必須要先登入才能使用
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $categories = Category::orderBy('id', 'ASC')->get();
        $restaurants = Restaurant::leftJoin('categories', 'restaurants.category_id', '=', DB::raw("CAST(categories.id AS CHAR)"))
            ->selectRaw('restaurants.* , categories.name AS categoryName')
            ->paginate(6);

        // dd($restaurants);

        $statusCollection = Favorite::where('user_id', Auth::id())
            ->get();

        $statusNew = array();
        foreach ($statusCollection as $status) {
            //注意這裡關聯性，這裡是以餐廳(restaurant_id)當作key值
            $statusNew[$status->restaurant_id] = $status;
        }

        return view('home', [
            'categoryID' => 0,
            'thisTypeRestaurants' => $restaurants,
            'allCategories' => $categories,
            'allNowStatus' => $statusNew]);
    }

    public function news()
    {
        $restaurants = Restaurant::orderBy('created_at', 'DESC')
            ->join('categories', 'restaurants.category_id', '=', DB::raw("CAST(categories.id AS CHAR)"))
            ->selectRaw('restaurants.* , categories.name AS categoryName')
            ->take(10)
            ->get();

        $comments = Comment::orderBy('updated_at', 'DESC')
            ->join('restaurants', 'comments.restaurant_id', '=', DB::raw("CAST(restaurants.id AS CHAR)"))
            ->join('users', 'comments.user_id', '=', DB::raw("CAST(users.id AS CHAR)"))
            ->selectRaw('comments.* , restaurants.name AS restaurantName, users.name AS userName')
            ->take(10)
            ->get();

        return view('otherPage.news', [
            'allRestaurants' => $restaurants,
            'allComments' => $comments]);
    }

    public function rank()
    {
        $statusCollection = Favorite::where('user_id', Auth::id())
            ->get();

        $statusNew = array();
        foreach ($statusCollection as $status) {
            //注意這裡關聯性，這裡是以餐廳(restaurant_id)當作key值
            $statusNew[$status->restaurant_id] = $status;
        }

        $restaurants_has_number = DB::table('restaurants')
            ->join('categories', 'restaurants.category_id', '=', DB::raw("CAST(categories.id AS CHAR)"))
            ->join('favorites', DB::raw("CAST(restaurants.id AS CHAR)"), '=', 'favorites.restaurant_id')
            ->select('restaurants.id',
                'restaurants.name',
                'restaurants.content',
                'categories.name AS categoryName',
                'restaurants.created_at',
                DB::raw("COUNT(*) AS favoriteNumber"))
            ->where('favorites.is_favorite', 'Y')
            ->groupBy('restaurants.id',
                'restaurants.name',
                'restaurants.content',
                'categories.name',
                'restaurants.created_at')
            ->orderBy('restaurants.created_at', 'DESC')
            ->get()
            ->toArray();

        for ($i = 0; $i < count($restaurants_has_number); $i++) {
            $idSet[$i] = $restaurants_has_number[$i]->id;
            $restaurants[$i] = (array) $restaurants_has_number[$i];
        }

        usort($restaurants, function ($restaurant1, $restaurant2) {
            return $restaurant2['favoriteNumber'] - $restaurant1['favoriteNumber'];
        });

        // dd($restaurants);

        $number = count($restaurants);

        if ($number < 10) {
            $restaurants_created_at = DB::table('restaurants')
                ->join('categories', 'restaurants.category_id', '=', DB::raw("CAST(categories.id AS CHAR)"))
                ->join('favorites', DB::raw("CAST(restaurants.id AS CHAR)"), '=', 'favorites.restaurant_id')
                ->select('restaurants.id',
                    'restaurants.name',
                    'restaurants.content',
                    'restaurants.created_at',
                    'categories.name AS categoryName')
                ->groupBy('restaurants.id',
                    'restaurants.name',
                    'restaurants.content',
                    'categories.name',
                    'restaurants.created_at')
                ->orderBy('restaurants.created_at', 'DESC')
                ->take(10)
                ->get()
                ->toArray();

            foreach ($restaurants_created_at as $restaurant_created_at) {
                if (in_array(((array) $restaurant_created_at)['id'], $idSet)) {
                    continue;
                } else {
                    $tempArray = (array) $restaurant_created_at;
                    $tempArray['favoriteNumber'] = "0";
                    $restaurants[$number] = $tempArray;
                    $number++;
                }
                if ($number == 10) {
                    break;
                }
            }
        }
        return view('otherPage.rank', [
            'allRestaurants' => $restaurants,
            'allNowStatus' => $statusNew]);
    }

    public function master()
    {
        $statusCollection = Relation::where('user_id', Auth::id())
            ->get();

        $statusNew = array();
        foreach ($statusCollection as $status) {
            //注意這裡關聯性，這裡是以對方(relation_user_id)當作key值
            $statusNew[$status->relation_user_id] = $status;
        }

        // dd($statusNew);

        $relations = DB::Table('interpersonal_relations')
            ->join('users', 'interpersonal_relations.user_id', '=', DB::raw("CAST(users.id AS CHAR)"))
            ->select('interpersonal_relations.user_id',
                'users.name AS userName', 'users.account AS userAccount', DB::raw('COUNT(*) AS followNumber'))
            ->where('interpersonal_relations.follow', 'Y')
            ->where('interpersonal_relations.user_id', '<>', Auth::id())
            ->groupBy('interpersonal_relations.user_id',
                'users.name', 'users.account')
            ->get();

        // dd($relations);

        return view('otherPage.master', [
            'allRelations' => $relations,
            'allNowStatus' => $statusNew]);
    }
}