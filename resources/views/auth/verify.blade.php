<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> Nhập mã OTP </title>
    <link rel="stylesheet" href="<?= asset('assets/css/login.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        @error('success')
            <span class="invalid-feedback ml-2" role="alert" style="color: yellow">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <form action="{{ route('auth.postVerify', $token) }}" method="POST">
            @csrf
            @method('POST')

            <input type="hidden" name="callback_url" value="{{ request('callback_url') }}">
            <div class="title">Nhập mã OTP</div>

            <div class="input-box underline">
                <input type="text" placeholder="Nhập mã OTP của bạn" name="otp">
                @error('otp')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
                <div class="underline"></div>
            </div>

            @error('message')
                <span class="invalid-feedback ml-2" role="alert" style="color: yellow">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="input-box button">
                <input type="submit" name="" value="Gửi">
            </div>
        </form>

        <div class="input-box">
            <form action="{{ route('auth.resendVerify', $token) }}" method="post">
                @csrf
                @method('POST')

                <button type="submit">Gửi lại mã OTP</button>
            </form>
        </div>
    </div>
</body>

</html>
