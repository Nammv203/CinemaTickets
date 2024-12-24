<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title> Đăng ký </title>
    <link rel="stylesheet" href="<?= asset('assets/css/login.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container" style="max-width: 450px !important">
    <form action="{{route('auth.postRegister')}}" method="POST">
        @csrf
        @method('POST')
        <div class="title">Đăng ký tài khoản</div>
        <div class="input-box underline">
            <input type="text" placeholder="Nhập email của bạn" value="{{old('email')}}" name="email">
            @error('email')
            <span class="text-danger">
                    {{$message}}
                </span>
            @enderror
            <div class="underline"></div>
        </div>
        <div class="input-box">
            <input type="text" placeholder="Nhập tên của bạn" name="name" value="{{old('name')}}">
            @error('name')
            <span class="text-danger">
                    {{$message}}
                </span>
            @enderror
            <div class="underline"></div>
        </div>
        <div class="input-box">
            <input type="text" placeholder="Nhập số điện thoại của bạn" name="phone" value="{{old('phone')}}">
            @error('phone')
            <span class="text-danger">
                    {{$message}}
                </span>
            @enderror
            <div class="underline"></div>
        </div>
        <div class="input-box">
            <input type="date" placeholder="YYYY-MM-DD" name="birthday" value="{{old('birthday')}}">
            @error('birthday')
            <span class="text-danger">
                    {{$message}}
                </span>
            @enderror
            <div class="underline"></div>
        </div>
        <div class="input-box">
            <input type="password" placeholder="Nhập mật khẩu" name="password">
            @error('password')
            <span class="text-danger">
                    {{$message}}
                </span>
            @enderror
            <div class="underline"></div>
        </div>
        <div class="input-box">
            <input type="password" placeholder="Nhập mật khẩu" name="password_confirmation">
            @error('password_confirmation')
            <span class="text-danger">
                    {{$message}}
                </span>
            @enderror
            <div class="underline"></div>
        </div>
        <div class="input-box">
            <a href="{{route('auth.showLoginForm')}}">Đăng nhập</a>
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
</div>
</body>
</html>
