@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection
@section('content')
<div class="content">
    <x-jet-authentication-card>
        <x-slot name="logo">
            <!-- <x-jet-authentication-card-logo /> -->
        </x-slot>
        <x-jet-validation-errors class="mb-4" />
        <div class="heading">
            <h2>会員登録</h2>
        </div>
        <div class="form">
            <form class="" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form__input">
                    <x-jet-input id="name" class="form__input--text" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="名前" />
                </div>
                <div class="form__input">
                    <x-jet-input id="email" class="form__input--text" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required />
                </div>
                <div class="form__input">
                    <x-jet-input id="password" class="form__input--text" type="password" name="password" required autocomplete="new-password" placeholder="パスワード" />
                </div>
                <div class="form__input">
                    <x-jet-input id="password_confirmation" class="form__input--text" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="パスワード確認" />
                </div>
                <div class="form__button">
                    <x-jet-button class="form__button-submit">
                        {{ __('会員登録') }}
                    </x-jet-button>

                </div>
                <div class="guide">
                    <p class="guide__text">アカウントをすでにお持ちの方はこちらから</p>
                    <a class="guide__login " href="{{ route('login') }}">
                        {{ __('ログイン') }}
                    </a>
                </div>
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" />
                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
                @endif
            </form>
        </div>
    </x-jet-authentication-card>
</div>
@endsection