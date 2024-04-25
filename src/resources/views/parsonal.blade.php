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
        <h2>社員No.{{ $user_id }}</h2>
        <h2> {{ $user_name }}様の勤務表 </h2>
        @if (isset($year))
        <h2>- {{$year}}年 {{$month}}月 -</h2>
        @endif
    </div>
    <div class="sort">
        <form action="/parsonal" class="sort-form">
            <select name="year" class="year" value="{{ old('year') }}">
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
            <select name="month" class="month" value="{{ old('month') }}">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <input type="hidden" name="user_name" value="{{ $user_name }}">
            <input type="hidden" name="records" class="sort" value="{{ $records }}">
            <button class="sort_button">絞込</button>
        </form>
    </div>
    <div class="roaster">
        <table class="roaster_list">
            <tr class="roaster_list-row">
                <th class="roaster_list-head">日時</th>
                <th class="roaster_list-head">勤務開始</th>
                <th class="roaster_list-head">勤務終了</th>
                <th class="roaster_list-head">休憩時間</th>
                <th class="roaster_list-head">勤務時間</th>
            </tr>
            @foreach($records as $record)
            <tr class="roaster_list-row">
                <td class="roaster_list-item">{{ $record->work_on->format("y/m/d") }}</td>
                <td class="roaster_list-item">{{ $record['start_at']->format("H:i:s") }}</td>
                @if ( empty( $record['finished_at'] ))
                <td class="roaster_list-item">-</td>
                @else
                <td class="roaster_list-item">{{ $record['finished_at']->format("H:i:s") }}</td>
                @endif
                <td class="roaster_list-item"><?php echo gmdate("H:i:s", $record['total_rest']) ?></td>
                <td class="roaster_list-item"><?php echo gmdate("H:i:s", $record['total_work']) ?></td>
            </tr>
            @endforeach
        </table>
        {{ $records->onEachSide(2)->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection