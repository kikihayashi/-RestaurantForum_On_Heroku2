<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function password()
    {
        $account = request('account');
        $email = request('email');

        $user = User::where('account', $account)->where('email', $email)->first();

        if (isset($user)) {
            return view('auth.passwords.resetPassword', ['userID' => $user->id]);
        } else {
            return redirect('/password/reset')
                ->with('message', '查無此帳號！');
        }

    }

    public function reset($userId)
    {
        $newPassword = request('password');
        $newPassword_confirmation = request('password_confirmation');

        if (!strcmp($newPassword, $newPassword_confirmation)) {
            if (strlen($newPassword) < 6) {
                return view('auth.passwords.resetPassword', ['userID' => $userId, 'errorMsg' => '密碼不可小於6個字元']);
            } else {
                $user = User::findOrFail($userId);
                $user->password = Hash::make(request('password'));
                $user->save();
                return view('auth.login');
            }
        } else {
            return view('auth.passwords.resetPassword', ['userID' => $userId, 'errorMsg' => '確認密碼不一致']);
        }

    }
}