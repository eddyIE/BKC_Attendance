<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function authenticate(Request $request){
        $credentials = $request->validate(
            ['username' => 'required', 'password' => 'required'],
            ['username.required' => 'Tên đăng nhập không được bỏ trống.', 'password.required' => 'Mật khẩu không được bỏ trống.']
        );

        $user = User::where([
            'username' => $credentials['username'],
            'password' => md5($credentials['password'])
        ])->first();

        Auth::login($user);

        if (Auth::check()){
            return redirect('/');
        }
        return redirect()->to('login')->withErrors('Tài khoản không tồn tại.');
    }
}
