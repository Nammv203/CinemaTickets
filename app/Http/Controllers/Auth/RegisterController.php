<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Models\User;
use App\Notifications\SendVerificationOtp;
use App\Repositories\UserRepository;
use App\Repositories\UserVerifyRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
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

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function postRegister(RegisterUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->fill($request->all());
            $user->password = bcrypt($request->password);
            $user->role_id = 0; // customer
            $user->is_verify = false;
            $user->save();

            $token = str::random(60); // Token ngẫu nhiên
            $otp = rand(1000, 9999); // OTP gồm 4 số

            $u_verify = [
                'user_id' => $user->id,
                'token' => $token,
                'otp' => $otp,
                'token_expires' => Carbon::now()->addMinutes(60),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $this->userVerifyRepository->create($u_verify);

            $user->notify(new SendVerificationOtp($otp));

            DB::commit();

            if ($user) {
                toastr()->success('Đăng ký tài khoản thành công!', 'Success');
                return redirect()->route('auth.showVerify', $token);
            }
            return redirect()->back()->with(['error' => 'Đăng ký thất bại, thử lại sau!']);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Đăng ký thất bại, thử lại sau!']);
        }
    }

    public function showVerifyForm($token)
    {
        $userVerify = $this->userVerifyRepository->where('token', $token)->get()->first();

        if ($userVerify == null) {
            toastr()->warning('Tài khoản không tồn tại, hãy đăng ký');
            return redirect()->route('auth.showRegistrationForm');
        }

        return view('auth.verify', compact('token'));
    }

    public function resendEmailVerify($token)
    {
        $userVerify = $this->userVerifyRepository->where('token', $token)->get()->first();
        $user = $this->userRepository->find($userVerify->user_id);

        // token hết hạn
        if (Carbon::parse($userVerify->token_expires) < Carbon::now()) {
            $userVerify->delete();
            $user->delete();

            toastr()->error('Mã OTP hết thời gian, vui lòng đăng ký lại tài khoản');
            return redirect()->route('auth.showRegistrationForm');
        } else {
            $user->notify(new SendVerificationOtp($userVerify->otp));

            toastr()->success('OTP đã gửi về hòm thư của bạn');
            return redirect()->back();
        }
    }

    public function postVerify(VerifyRequest $request)
    {
        $verify = $this->userVerifyRepository->where('token', $request->token)->first();

        // token hết hạn
        if (!$verify || $verify->token_expires < Carbon::now()) {
            $verify->delete();
            toastr()->error('Mã OTP đã hết hạn, vui lòng đăng kí lại tài khoản');
            return redirect()->route('auth.showRegistrationForm');
        }

        // sai otp
        if ($verify->otp != $request->otp) {
            toastr()->error('Mã OTP không đúng');
            return redirect()->back();
        }

        // Xác minh thành công
        $user = $this->userRepository->find($verify->user_id);
        $data['is_verify'] = true;

        $this->userRepository->update($data, $user->id);

        $verify->delete();

        toastr()->success('Xác thực thành công, bạn có thể đăng nhập');
        return redirect()->route('auth.showLoginForm');
    }
}
