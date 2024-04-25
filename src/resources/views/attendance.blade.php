@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
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
    @endif @if ($errors->any())
    <div class="todo__alert--danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="heading">
        <h2>{{ Auth::user()->name }}さんお疲れ様です！</h2>
    </div>
    <div class="buttons">
        <div class="buttons__work">
            <form class="form" action="/startwork" method="post">
                @csrf
                <div class="form__button">
                    <button class="form__button-submit" type="submit">勤務開始</button>
                </div>
            </form>
            <form class="form" action="/finishwork" method="post">
                @csrf
                <div class="form__button">
                    <button class="form__button-submit" type="submit">勤務終了</button>
                </div>
            </form>
        </div>
        <div class="buttons__break">
            <form class="form" action="/startrest" method="post">
                @csrf
                <div class="form__button">
                    <button class="form__button-submit" type="submit">休憩開始</button>
                </div>
            </form>
            <form class="form" action="/finishrest" method="post">
                @csrf
                <div class="form__button">
                    <button class="form__button-submit" type="submit">休憩終了</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection