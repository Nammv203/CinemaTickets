<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        try {
            // Validate the login request
            $credentials = $request->only('email', 'password');

            // Attempt to log the user in
            if (Auth::attempt($credentials)) {
                // Regenerate session to prevent session fixation
                $request->session()->regenerate();

                // Redirect to the intended page
                if(auth()->check() && auth()->user()->role_id == 1){
                    toastr()->success('Đăng nhập trang admin thành công.');
                    return redirect()->route('admin.dashboard');
                }

                toastr()->success('Đăng nhập thành công.');
                return redirect()->route('client.home');
            }

            toastr()->error('Tài khoản hoặc mật khẩu không chính xác!');
            return redirect()->back();
        }catch (\Throwable $th) {
            toastr()->error('Đăng nhập thất bại. Vui lòng đăng nhập lại ');
            Log::error($th->getMessage());
            return redirect()->back();
        }
    }
}