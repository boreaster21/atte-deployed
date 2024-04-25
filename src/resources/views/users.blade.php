@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('nav')
<nav class="header__nav">
    <ul class="nav__list">
        <li class="nav__list-item"><a href="/">打刻</a></li>
        <li class="nav__list-item"><a href="/date">全体勤怠表</a></li>
        <li class="nav__list-item"><a href="/users">ユーザー一覧</a></li>
        <li class="nav__list-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="button-logout">ログアウト</button>
            </form>
        </li>
    </ul>
</nav>
@endsection

@section('content')
<div class="content">
    @if (session('message'))
    <div class="todo__alert--success">{{ session('message') }}</div>
    @endif
    @if ($errors->any())
    <div class="todo__alert--danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="heading">
        <h2> ユーザー一覧</h2>
    </div>
    <div class="serch">
        <form class="search-form" action="/users" method="get">
            @csrf
            <label>
                <input class="search-form__item-input" type="text" name="keyword" placeholder="キーワードを入力" value="{{ old('keyword') }}">
            </label>
            <div class="search-form__button">
                <button class="search-form__button-submit" type="submit" aria-label="検索"></button>
            </div>
        </form>
    </div>
    <div class="roaster">
        <table class="roaster_list">
            <tr class="roaster_list-row">
                <th class="roaster_list-head">ID</th>
                <th class="roaster_list-head">名前</th>
                <th class="roaster_list-head">メールアドレス</th>
            </tr>
            @foreach($users as $user)
            <tr class="roaster_list-row">
                <form method="post" name="serch1" action="/parsonal">
                    @csrf
                    <td class="roaster_list-item"><button class="roaster_button" type="submit">{{ $user['id'] }}</button></td>
                    <td class="roaster_list-item"><button class="roaster_button" type="submit">{{ $user['name'] }}</button></td>
                    <td class="roaster_list-item"><button class="roaster_button" type="submit">{{ $user['email'] }}</button></td>

                    <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                    <input type="hidden" name="user_name" value="{{ $user['name'] }}">
                    <input type="hidden" name="user_email" value="{{ $user['email'] }}">
                    <input type="hidden" name="serch" value="">
                </form>
            </tr>
            @endforeach
        </table>
        {{ $users->onEachSide(2)->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection