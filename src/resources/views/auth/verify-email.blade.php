<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <!-- <x-jet-authentication-card-logo /> -->
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            ご登録ありがとうございます！<br>
            ご入力いただいたメールアドレスへ認証リンクを送信しました。<br>
            クリックして認証を完了させてください。<br>
            もし、認証メールが届かない場合は再送させていただきます。
        </div>

        @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            新しい認証メールが送信されました。
        </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        認証メールを再送する
                    </x-jet-button>
                </div>
            </form>

            <div>
                <!-- <a href="{{ route('profile.show') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Edit Profile') }}</a> -->

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>