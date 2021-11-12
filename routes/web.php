<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

//使用中文語系，需要在lang裡新增zh_tw資料夾>auth.php進行設定
App::setLocale('zh_tw');

Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

//parameter是代表參數，可以換別的，不影響結果------------------------------

//找回密碼
Route::post('/password/reset/password', 'PasswordController@password')->name('PasswordController.password');
//重設密碼
Route::post('/password/reset/{id}', 'PasswordController@reset')->name('PasswordController.reset');

//首頁(4個分頁)----------------------------------------------------
//首頁
Route::get('/', 'HomeController@home')->name('HomeController.home');
Route::get('/home', 'HomeController@home')->name('HomeController.home');
//最新動態
Route::get('/news', 'HomeController@news')->name('HomeController.news');
//TOP 10人氣餐廳
Route::get('/rank', 'HomeController@rank')->name('HomeController.rank');
//美食達人
Route::get('/master', 'HomeController@master')->name('HomeController.master');

//首頁查看所有餐廳or各別餐廳
Route::get('/category/{parameter}', 'RestaurantController@category')->name('RestaurantController.category');

//必須要先登入才能使用
Route::group(['middleware' => 'auth'], function () {

    //進到單一餐廳頁面
    Route::get('/restaurant/{parameter}', 'RestaurantController@restaurant')->name('RestaurantController.restaurant');

    //進到單一餐廳評論資訊頁面
    Route::get('/restaurant/{parameter}/info', 'RestaurantController@info')->name('RestaurantController.info');

    //評論餐廳
    Route::post('/restaurant/{parameter}/comment', 'RestaurantController@comment')->name('RestaurantController.comment');

    //刪除餐廳評論
    Route::delete('/restaurant/{parameter}/deleteComment', 'RestaurantController@deleteComment')->name('RestaurantController.deleteComment');

    //第一次加入最愛或按讚
    Route::post('/restaurant/{id}/writeFavoriteAndLike/{pageType}/{categoryId}/{paginate}', 'RestaurantController@writeFavoriteAndLike')->name('RestaurantController.writeFavoriteAndLike');

    //更新->取消or加入最愛、按讚or退讚
    Route::put('/restaurant/{id}/updateFavoriteAndLike/{pageType}/{categoryId}/{paginate}', 'RestaurantController@updateFavoriteAndLike')->name('RestaurantController.updateFavoriteAndLike');

    //使用者相關(包含管理員後台、個人資訊、修改密碼)---------------------------

    //使用者頁面
    Route::get('/userInfo/user/{parameter}', 'UserInfoController@user')->name('UserInfoController.user');

    //帳號設定頁面
    Route::get('/userInfo/manage', 'UserInfoController@manage')->name('UserInfoController.manage');

    //帳號更新
    Route::put('/userInfo/manage', 'UserInfoController@writeAccount')->name('UserInfoController.writeAccount');

    //帳號停用
    Route::delete('/userInfo/manage', 'UserInfoController@deleteAccount')->name('UserInfoController.deleteAccount');

    //一般使用者會用到的功能--------------------------------------------------

    //修改個人簡介頁面
    Route::get('/userInfo/user/{parameter}/introduction_edit', 'UserInfoController@introduction')->name('UserInfoController.introduction');

    //更新個人簡介
    Route::put('/userInfo/user/{parameter}/introduction_edit', 'UserInfoController@editIntroduction')->name('UserInfoController.editIntroduction');

    //好友列表頁面
    Route::get('/userInfo/user/{parameter}/friend_list', 'UserInfoController@friend')->name('UserInfoController.friend');

    //第一次加入好友或追蹤
    Route::post('/userInfo/user/{id}/writeFriendOrFollow/{type}', 'UserInfoController@writeFriendOrFollow')->name('UserInfoController.writeFriendOrFollow');

    //更新->取消or加入好友、追蹤or退追蹤
    Route::put('/userInfo/user/{id}/updateFriendOrFollow/{type}', 'UserInfoController@updateFriendOrFollow')->name('UserInfoController.updateFriendOrFollow');

    //後台管理員會用到的功能，必須是管理員才能使用，否則跳轉到首頁
    Route::group(['middleware' => 'admin'], function () {

        //所有餐廳頁面
        Route::get('/userInfo/admin/restaurants', 'UserInfoController@showRestaurant')->name('UserInfoController.showRestaurant');

        //新增餐廳列表頁面(注意這個和底下的route，因為網址結尾格式一樣，所以要把create放上面為優先)
        Route::get('/userInfo/admin/restaurants/create', 'UserInfoController@writeRestaurant')->name('UserInfoController.createRestaurant');

        //查看餐廳各別資訊頁面(注意這個和上面的route，因為網址結尾格式一樣，所以要把{id}放底下為後排)
        Route::get('/userInfo/admin/restaurants/{id}', 'UserInfoController@readRestaurant')->name('UserInfoController.readRestaurant');

        //新增餐廳
        Route::post('/userInfo/admin/restaurants', 'UserInfoController@addRestaurant')->name('UserInfoController.addRestaurant');

        //編輯餐廳列表頁面
        Route::get('/userInfo/admin/restaurants/{id?}/update', 'UserInfoController@writeRestaurant')->name('UserInfoController.updateRestaurant');

        //編輯餐廳
        Route::put('/userInfo/admin/restaurants/{parameter}', 'UserInfoController@editRestaurant')->name('UserInfoController.editRestaurant');

        //刪除餐廳
        Route::delete('/userInfo/admin/restaurants/{parameter}', 'UserInfoController@deleteRestaurant')->name('UserInfoController.deleteRestaurant');

        //----------------------------------------------------------------------

        //餐廳種類頁面
        Route::get('/userInfo/admin/categories', 'UserInfoController@showCategory')->name('UserInfoController.showCategory');

        //新增餐廳種類
        Route::post('/userInfo/admin/categories', 'UserInfoController@addCategory')->name('UserInfoController.addCategory');

        //編輯餐廳種類
        Route::put('/userInfo/admin/categories', 'UserInfoController@editCategory')->name('UserInfoController.editCategory');

        //刪除餐廳種類
        Route::delete('/userInfo/admin/categories', 'UserInfoController@deleteCategory')->name('UserInfoController.deleteCategory');
    });
});