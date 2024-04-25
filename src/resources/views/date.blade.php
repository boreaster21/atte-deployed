@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css') }}">
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
        <form class="form_yesterday" method="POST" action="/date">
            @csrf
            <input type="hidden" name="day" value="{{ $day }}">
            <input type="hidden" name="before" value="before">
            <button type="submit" class="button_yesterday">
                < </button>
        </form>
        <h2> {{ $day }} </h2>
        <form class="form_tommorow" method="POST" action="/date">
            @csrf
            <input type="hidden" name="day" value="{{ $day }}">
            <input type="hidden" name="after" value="after">
            <button type="submit" class="button_tommorow">
                >
            </button>
        </form>
    </div>
    <div class="roaster">
        <table class="roaster_list">
            <tr class="roaster_list-row">
                <th class="roaster_list-head">名前</th>
                <th class="roaster_list-head">勤務開始</th>
                <th class="roaster_list-head">勤務終了</th>
                <th class="roaster_list-head">休憩時間</th>
                <th class="roaster_list-head">勤務時間</th>
            </tr>
            @foreach($dates as $date)
            <tr class="roaster_list-row">
                @foreach($users as $user)
                @if($user['id'] == $date['user_id'])
                <td class="roaster_list-item">{{ $user['name'] }}</td>
                @endif
                @endforeach
                <td class="roaster_list-item">{{ $date['start_at']->format("H:i:s") }}</td>
                @if ($date['finished_at'] == null)
                <td class="roaster_list-item">-</td>
                @else
                <td class="roaster_list-item">{{ $date['finished_at']->format("H:i:s") }}</td>
                @endif
                <td class="roaster_list-item"><?php echo gmdate("H:i:s", $date['total_rest']) ?></td>
                <td class="roaster_list-item"><?php echo gmdate("H:i:s", $date['total_work']) ?></td>
            </tr>
            @endforeach
        </table>
        {{ $dates->onEachSide(2)->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection