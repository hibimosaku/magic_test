@extends('layouts.layout-nonav')
@section('content')

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label for="email">メールアドレス</label>
        <input id="email" class="" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
        @if($errors->has('email'))
        <span class="text-red-500">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="mt-4">
        <label for="password">パスワード</label>
        <input id="password" class="" type="password" name="password" required autocomplete="current-password" />
        @if($errors->has('password'))
        <span class="text-red-500">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div class="block mt-4">
        <label for="remember_me" class="">
            <input id="remember_me" type="checkbox" name="remember">
            <span class="ml-2 text-sm">ログイン情報を記録</span>
        </label>
    </div>
    <div class="">
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}">パスワード忘れた場合</a>
        @endif
        <br>
        <button class="button" type="submit">ログイン</button>
    </div>
</form>
@endsection