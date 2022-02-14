<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Relation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserInfoController extends Controller
{
    //使用者資訊($selectUserID=選取的人的ID)
    public function user($selectUserID)
    {
        $user = User::findOrFail($selectUserID);

        $comments = DB::table('comments')
            ->join('restaurants', 'comments.restaurant_id', '=', DB::raw("CAST(restaurants.id AS VARCHAR)"))
            ->select('comments.restaurant_id', 'restaurants.name AS restaurant_name')
            ->where('comments.user_id', $selectUserID)
            ->groupBy('comments.restaurant_id', 'restaurants.name')
            ->get();

        $favorite = Favorite::where('user_id', $selectUserID)
            ->where('is_favorite', '=', 'Y')
            ->join('restaurants', 'favorites.restaurant_id', '=', DB::raw("CAST(restaurants.id AS VARCHAR)"))
            ->selectRaw('favorites.* , restaurants.name AS restaurant_name')
            ->get();

        $status = Relation::where('user_id', Auth::id())
            ->where('relation_user_id', $selectUserID)
            ->selectRaw('interpersonal_relations.follow , interpersonal_relations.friend')
            ->first();

        $follow = Relation::where('user_id', $selectUserID)
            ->where('follow', 'Y')
            ->join('users', 'interpersonal_relations.relation_user_id', '=', DB::raw("CAST(users.id AS VARCHAR)"))
            ->selectRaw('interpersonal_relations.* , users.name AS relation_user_name, users.account AS relation_user_account')
            ->get();

        $follower = Relation::where('relation_user_id', $selectUserID)
            ->where('follow', 'Y')
            ->join('users', 'interpersonal_relations.user_id', '=', DB::raw("CAST(users.id AS VARCHAR)"))
            ->selectRaw('interpersonal_relations.* , users.name AS relation_user_name, users.account AS relation_user_account')
            ->get();

        $friend = Relation::where('user_id', $selectUserID)
            ->where('friend', 'Y')
            ->join('users', 'interpersonal_relations.relation_user_id', '=', DB::raw("CAST(users.id AS VARCHAR)"))
            ->selectRaw('interpersonal_relations.* , users.name AS relation_user_name, users.account AS relation_user_account')
            ->get();

        $array = [
            'thisUser' => $user,
            'allComment' => $comments,
            'allFavorite' => $favorite,
            'nowStatus' => $status,
            'allFollow' => $follow,
            'allFollower' => $follower,
            'allFriend' => $friend,
        ];

        return view('userInfo.user', $array);
    }

    //帳號設定頁面
    public function manage()
    {
        $user = User::findOrFail(Auth::id());

        return view('userInfo.manage', ['user' => $user]);
    }

    public function writeAccount()
    {
        $user = User::findOrFail(Auth::id());
        $newAccount = request('user');
        $checkUser = User::where('email', $newAccount['new_email'])->first();

        if (isset($checkUser)) {
            if ($checkUser->id != Auth::id()) {
                return redirect(route('UserInfoController.manage'))->with('errorMessage', '此信箱已有人使用');
            }
        }
        //如果目前密碼確認無誤
        if (Hash::check($newAccount['password'], $user->password)) {

            //如果沒有重設密碼
            if ($newAccount['new_password'] == null && 
           $newAccount['new_password_confirmation'] == null) {
                $user = User::findOrFail(Auth::id());
                $user->name = $newAccount['new_name'];
                $user->email = $newAccount['new_email'];
                $user->save();
                return redirect(route('HomeController.home'))->with('message', '資料修改成功！');
            } else {
                //如果新密碼 & 再次驗證相同
                if (!strcmp($newAccount['new_password'], $newAccount['new_password_confirmation'])) {
                    $user = User::findOrFail(Auth::id());
                    $user->name = $newAccount['new_name'];
                    $user->email = $newAccount['new_email'];

                    //如果新密碼有填東西
                    if (strlen($newAccount['new_password']) > 0) {
                        //如果新密碼有小於6個字元，跳出錯誤，密碼至少6個字元
                        if (strlen($newAccount['new_password']) < 6) {
                            return redirect(route('UserInfoController.manage'))->with('errorMessage', '新密碼至少6個字元！');
                        }
                        $user->password = Hash::make($newAccount['new_password']);
                    }
                    $user->save();
                    return redirect(route('HomeController.home'))->with('message', '資料修改成功！');
                }
                //如果新密碼 & 再次驗證不相同，跳出錯誤
                else {
                    return redirect(route('UserInfoController.manage'))->with('errorMessage', '新密碼與再次輸入不一致！');
                }
            }
        }
        //如果密碼錯誤，跳出錯誤不可修改
        else {
            return redirect(route('UserInfoController.manage'))->with('errorMessage', '當前密碼輸入錯誤！');
        }
    }

    public function deleteAccount()
    {
        $user = User::findOrFail(Auth::id());

        $user->delete();

        return redirect(route('HomeController.home'));
    }

    //以下是一般使用者的功能-------------------------------------------------------

    //個人簡介頁面
    public function introduction($selectUserID)
    {
        $user = User::findOrFail($selectUserID);

        return view('userInfo.detail.introduction', ['thisUser' => $user]);
    }

    //個人簡介頁面
    public function editIntroduction(Request $request, $userID)
    {
        $userArray = $_POST['user'];
        $newName = $userArray[0];
        $newIntroduction = $userArray[1];

        $request->validate([
            'image.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($file = $request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $destinationPath = public_path() . '/img';
            $fileName = Auth::user()->account . '.jpg';
            $file->move($destinationPath, $fileName);
        }

        $user = User::findOrFail($userID);

        $user->name = $newName;
        $user->introduction = $newIntroduction;

        $user->save();

        return redirect(route('UserInfoController.user', $userID));
    }

    //好友列表頁面
    public function friend($userID)
    {
        $friends = Relation::where('user_id', $userID)
            ->where('friend', 'Y')
            ->join('users', 'interpersonal_relations.relation_user_id', '=', DB::raw("CAST(users.id AS VARCHAR)"))
            ->selectRaw('interpersonal_relations.* , users.name AS relation_user_name, users.account AS relation_user_account')
            ->get();

        return view('userInfo.detail.friend', ['allFriends' => $friends]);
    }

    public function writeFriendOrFollow($selectUserID, $pageType)
    {
        $relation_user_to_person = new Relation();
        $relation_user_to_person->user_id = Auth::id();
        $relation_user_to_person->relation_user_id = $selectUserID;

        $relation_person_to_user = new Relation();
        $relation_person_to_user->user_id = $selectUserID;
        $relation_person_to_user->relation_user_id = Auth::id();

        $type = request('type');

        switch ($type) {
            case 'Follow':
                $relation_user_to_person->follow = 'Y';
                $relation_user_to_person->friend = 'N';

                $relation_person_to_user->follow = 'N';
                $relation_person_to_user->friend = 'N';

                break;
            case 'Friend':
                $relation_user_to_person->follow = 'N';
                $relation_user_to_person->friend = 'Y';

                $relation_person_to_user->follow = 'N';
                $relation_person_to_user->friend = 'Y';
                break;
        }

        $relation_user_to_person->save();
        $relation_person_to_user->save();

        switch ($pageType) {
            case 'user':
                return redirect(route('UserInfoController.user', $selectUserID));
            case 'master':
                return redirect(route('HomeController.master'));
        }
    }

    public function updateFriendOrFollow($selectUserID, $pageType)
    {
        $relation_user_to_person =
        Relation::where('user_id', Auth::id())
            ->where('relation_user_id', $selectUserID)
            ->firstOrFail();

        $relation_person_to_user =
        Relation::where('user_id', $selectUserID)
            ->where('relation_user_id', Auth::id())
            ->firstOrFail();

        $type = request('type');
        switch ($type) {
            case 'Follow':
                if ($relation_user_to_person->follow == 'Y') {
                    $relation_user_to_person->follow = 'N';
                } else {
                    $relation_user_to_person->follow = 'Y';
                }
                break;

            case 'Friend':
                if ($relation_user_to_person->friend == 'Y') {
                    $relation_user_to_person->friend = 'N';
                    $relation_person_to_user->friend = 'N';
                } else {
                    $relation_user_to_person->friend = 'Y';
                    $relation_person_to_user->friend = 'Y';
                }
                break;
        }

        $relation_user_to_person->save();
        $relation_person_to_user->save();

        switch ($pageType) {
            case 'user':
                return redirect(route('UserInfoController.user', $selectUserID));
            case 'master':
                return redirect(route('HomeController.master'));
        }
    }

    //以下是管理員才能使用的功能-------------------------------------------------------

    //所有餐廳頁面
    public function showRestaurant()
    {
        $restaurants = Restaurant::orderBy('restaurants.updated_at', 'DESC')
            ->join('categories', 'restaurants.category_id', '=', DB::raw("CAST(categories.id AS VARCHAR)"))
            ->selectRaw('restaurants.* , categories.name AS category_name')
            ->paginate(5);

        // dd($restaurants);

        //資料夾寫法
        return view('userInfo.admin.restaurants', ['allRestaurants' => $restaurants]);
    }

    //單一餐廳資訊頁面
    public function readRestaurant($id)
    {
        $restaurant = Restaurant::where('restaurants.id', '=', $id)
            ->join('categories', 'restaurants.category_id', '=', DB::raw("CAST(categories.id AS VARCHAR)"))
            ->selectRaw('restaurants.* , categories.name AS category_name')
            ->firstOrFail();

        return view('userInfo.admin.read', ['thisRestaurant' => $restaurant]);
    }

    //編輯or新增餐廳頁面
    public function writeRestaurant($id = null)
    {
        $categories = Category::orderByRaw("CASE WHEN name = '未分類' THEN 1 ELSE 2 END DESC")
            ->orderBy('updated_at', 'DESC')->get();

        $editRestaurant = null;

        //如果$id有值，代表是編輯餐廳
        if ($id != null) {
            $editRestaurant = Restaurant::findOrFail($id);
        }
        //資料夾寫法
        return view('userInfo.admin.write', [
            'allCategories' => $categories,
            'restaurant' => $editRestaurant,
        ]);
    }

    //儲存的過程(無頁面，會回到所有餐廳)
    public function addRestaurant()
    {
        $restaurant = new Restaurant(); //Eloquent Model(對應資料庫欄位)

        $restaurant->category_id = request('category');
        $restaurant->name = request('name');
        $restaurant->content = request('content');
        $restaurant->opening_hour = request('opening_hour');
        $restaurant->tel = request('tel');
        $restaurant->address = request('address');

        //存入資料庫
        $restaurant->save();

        return redirect(route('UserInfoController.showRestaurant'))->with('message', '餐廳新增成功！');
    }

    //編輯的過程(無頁面，會回到所有餐廳)
    public function editRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id); //Eloquent Model(對應資料庫欄位)

        $restaurant->category_id = request('category');
        $restaurant->name = request('name');
        $restaurant->content = request('content');
        $restaurant->opening_hour = request('opening_hour');
        $restaurant->tel = request('tel');
        $restaurant->address = request('address');

        //更新資料庫
        $restaurant->save();

        return redirect(route('UserInfoController.readRestaurant', $id))->with('message', '餐廳更新成功！');
    }

    //刪除的過程(無頁面，會回到所有餐廳)，此寫法可和刪除餐廳種類比較
    public function deleteRestaurant($id)
    {
        //找到此id的資料
        $restaurant = Restaurant::findOrFail($id);

        //刪除此id的資料
        $restaurant->delete();

        return redirect(route('UserInfoController.showRestaurant'));
    }

    //--------------------------------------------------------------------------------

    //餐廳種類頁面
    public function showCategory()
    {
        $categories = Category::where('name', '<>', '未分類')->orderBy('updated_at', 'DESC')->get();

        //資料夾寫法
        return view('userInfo.admin.categories', ['allCategories' => $categories]);
    }

    //儲存的過程(無頁面，會回到餐廳種類)
    public function addCategory()
    {
        //確認新增的餐廳種類是否已存在
        $maybeHaveThisCategory = Category::where('name', request('categoryName'))->first();

        if (isset($maybeHaveThisCategory->name)) {
            return redirect(route('UserInfoController.showCategory'))->with('errorMessage', '此餐廳種類已存在！');
        } else {
            $category = new Category(); //Eloquent Model(對應資料庫欄位)

            $category->name = request('categoryName');

            //存入資料庫
            $category->save();

            return redirect(route('UserInfoController.showCategory'))->with('message', '種類新增成功！');
        }

        // if (request('categoryName') != null) {
        //     $category = new Category(); //Eloquent Model(對應資料庫欄位)

        //     $category->name = request('categoryName');

        //     //存入資料庫

        //     $category->save();

        //     return redirect(route('UserInfoController.showCategory'));
        // } else {
        //     return redirect(route('UserInfoController.showCategory'))->with('errorMessage', '種類不可為空！');
        // }
    }

    //編輯的過程(無頁面，會回到餐廳種類)
    public function editCategory()
    {
        $categoryArray = $_POST['category'];
        $id = $categoryArray[0];
        $name = $categoryArray[1];

        //找出此id的資料
        $category = Category::findOrFail($id);

        //將新名稱取代舊名稱
        $category->name = $name;

        //更新資料庫
        $category->save();

        return redirect(route('UserInfoController.showCategory'));
    }

    //刪除的過程(無頁面，會回到餐廳種類)，此寫法可和刪除所有餐廳比較
    public function deleteCategory()
    {
        $id = request('categoryID');

        //找到此id的資料
        $category = Category::findOrFail($id);

        //得到未分類的id
        $unCategorizedId = Category::where('name', '未分類')->get()->get(0)->id;

        $restaurants = Restaurant::where('category_id', $id)->get();

        //將原本餐廳的種類id改為未分類的unCategorizedId，並更新
        foreach ($restaurants as $restaurant) {
            $restaurant->category_id = $unCategorizedId;
            $restaurant->save();
        }

        //刪除此id的資料
        $category->delete();

        return redirect(route('UserInfoController.showCategory'))->with('message', '種類刪除成功！');
    }
}