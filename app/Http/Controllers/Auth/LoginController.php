<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use App\Repositories\UserVerifyRepository;

class LoginController extends Controller
{
    protected $userVerifyRepository;
    protected $userRepository;

    public function __construct(
        UserVerifyRepository $userVerifyRepository,
        UserRepository $userRepository
    ) {
        $this->userVerifyRepository = $userVerifyRepository;
        $this->userRepository = $userRepository;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        try {
            // Validate the login request
            $credentials = $request->only('email', 'password');

            // checking account is active
            $userExists = User::where('email', $credentials['email'])
                ->first();

            if($userExists && !$userExists->is_active)
            {
                toastr()->error('Tài khoản của bạn bị khóa, liên hệ admin để xử lý!');
                return redirect()->back();
            }

            if($userExists && !$userExists->is_verify)
            {
                $userVefiry = $this->userVerifyRepository->where('user_id', $userExists->id)->first();
                resend_email_verify($userVefiry->token);

                toastr()->error('Tài khoản của bạn cần xác thực để đăng nhập');
                return redirect()->route('auth.showVerify', $userVefiry->token);
            }

            // Attempt to log the user in
            if (Auth::attempt($credentials)) {
                // Regenerate session to prevent session fixation
                $request->session()->regenerate();

                // redirect callback url
                if($request->callback_url){
                    return redirect($request->callback_url);
                }

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
            toastr()->error('Đăng nhập thất bại.');
            Log::error($th->getMessage());
            return redirect()->back();
        }
    }
}
