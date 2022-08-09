<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /* VIEWW=
    // GET: /login */
    public function index(){
//        session()->all();
        if (Auth::check()){
            if (Auth::user()->role == 0){
                return redirect('/');
            } else {
                return redirect('/admin');
            }
        }
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

        if ($user != null){
            Auth::login($user);

            if (Auth::check()){
                if (Auth::user()->role == 0){
                    return redirect('/');
                } else {
                    return redirect('/admin');
                }
            }
        }
        return redirect()->to('login')->withErrors('Tài khoản không tồn tại.');
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
