@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="content">
    <x-jet-authentication-card>
        <x-slot name="logo"><!-- <x-jet-authentication-card-logo /> --></x-slot>
        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
        <div>{{ session('status') }}</div>
        @endif

        <div class="heading">
            <h2>ログイン</h2>
        </div>

        <div class="form">
            <form class="" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form__input">
                    <x-jet-input id="email" class="form__input--text" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required autofocus />
                </div>
                <div class="form__input">
                    <x-jet-input id="password" class="form__input--text" type="password" name="password" placeholder="パスワード" required autocomplete="current-password" />
                </div>

                <div class="form__button">
                    @if (Route::has('password.request'))
                    <a class="form__error" href="{{ route('password.request') }}">
                        {{ __('パスワードをお忘れですか') }}
                    </a>
                    @endif
                    <x-jet-button class="form__button-submit">{{ __('ログイン') }}</x-jet-button>
                </div>
                <div class="form__remember">
                    <label for="remember_me" class="">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="">{{ __('ログイン情報を記憶する') }}</span>
                    </label>
                </div>


                <div class="guide">
                    <p class="guide__text">アカウントをお持ちでない方はこちらから</p>
                    <a class="guide__register" href="/register">会員登録</a>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</div>
@endsection