<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Date;
use App\Models\User;
use App\Models\Keyword;
use Carbon\Carbon;

class AtteController extends Controller
{
  public function index()
  {
    // $user = Auth::user();
    // $latest_work = Work::latest('work_on')->where('user_id', $user->id)->orderBy('id', 'DESC')->where('finished_at', null)->first();
    // if ($latest_work) {
    //   dd('a');
    //   if (empty($latest_work->start_rest) && empty($latest_work->finished_rest)) {
    //     $finished_at = $latest_work->start_at->modify('+9 hour');
    //     $total_work = $latest_work->start_at->diffInSeconds($finished_at);
    //     $start_rest = $latest_work->start_at->modify('+4 hour');
    //     $finished_rest = $start_rest->modify('+1 hour');
    //     $total_rest = $start_rest->diffInSeconds($finished_rest);
    //     $latest_work->update([
    //       'finished_at' => $finished_at,
    //       'total_work' => $total_work,
    //       'start_rest' => $start_rest,
    //       'finished_rest' => $finished_rest,
    //       'total_rest' => $total_rest,
    //     ]);
    //     return view('attendance')->with('message', '前回の出勤操作から日を跨いだ為で本日の出勤操作に切り替えます');
    //   } elseif (isset($latest_work->start_rest) && empty($latest_work->finished_rest)) {
    //     $finished_at = $latest_work->start_at->modify('+9 hour');
    //     $total_work = $latest_work->start_at->diffInSeconds($finished_at);
    //     $start_rest = $latest_work->start_rest;
    //     $finished_rest = $start_rest->modify('+1 hour');
    //     $total_rest = $start_rest->diffInSeconds($finished_rest);
    //     if ($finished_at < $finished_rest) {
    //       $total_work = $latest_work->start_at->diffInSeconds($finished_rest);
    //       $latest_work->update([
    //         'finished_at' => $finished_rest,
    //         'total_work' => $total_work,
    //         'finished_rest' => $finished_rest,
    //         'total_rest' => $total_rest,
    //       ]);
    //       return view('attendance')->with('message', '前回の出勤操作から日を跨いだ為で本日の出勤操作に切り替えます');
    //     } else {
    //       $latest_work->update([
    //         'finished_at' => $finished_at,
    //         'total_work' => $total_work,
    //         'finished_rest' => $finished_rest,
    //         'total_rest' => $total_rest,
    //       ]);
    //       return view('attendance')->with('message', '前回の出勤操作から日を跨いだ為で本日の出勤操作に切り替えます');
    //     }
    //   } elseif (isset($latest_work->start_rest) && isset($latest_work->finished_rest)) {
    //     $latest_total_rest = $latest_work->total_rest;
    //     if ($latest_total_rest < 3600) {
    //       $finished_at = $latest_work->start_at->modify('+9 hour');
    //       $total_work = $latest_work->start_at->diffInSeconds($finished_at);
    //       $latest_work->update([
    //         'finished_at' => $finished_at,
    //         'total_work' => $total_work,
    //         'total_rest' => 3600,
    //       ]);
    //       return view('attendance')->with('message', '前回の出勤操作から日を跨いだ為で本日の出勤操作に切り替えます');
    //     } else {
    //       $finished_at = $latest_work->start_at->modify('+9 hour');
    //       $total_work = $latest_work->start_at->diffInSeconds($finished_at);
    //       $latest_work->update([
    //         'finished_at' => $finished_at,
    //         'total_work' => $total_work,
    //       ]);
    //       return view('attendance')->with('message', '前回の出勤操作から日を跨いだ為で本日の出勤操作に切り替えます');
    //     }
    //   }
    // } else {
    //   return view('attendance');
    // }
    return view('attendance');
  }

  public function startwork()
  {
    $user = Auth::user();
    $start_work = Carbon::now();
    $today = Carbon::today();
    if (Work::whereDate('work_on', $today)->where('user_id', $user->id)->first()) {
      return redirect()->back()
        ->with('message', '本日すでに出勤打刻を完了しています');
    } elseif (Work::whereDate('work_on', $today)->where('user_id', $user->id)->first() == null) {
      Work::create([
        'start_at' => $start_work,
        'user_id' => $user->id,
        'work_on' => $start_work,
      ]);
      return redirect()->back()
        ->with('message', '出勤打刻が完了しました');
    }
  }

  public function finishwork()
  {
    $user = Auth::user();
    $finish_work = Carbon::now();
    $target = Work::whereDate('start_at', $finish_work)->where('user_id', $user->id)->where('finished_at', null)->first();
    $work_notstarted = Work::whereDate('work_on', $finish_work)->where('user_id', $user->id)->first() == null;
    $alreadyfinished = Work::whereDate('finished_at', $finish_work)->where('user_id', $user->id)->first();

    if ($work_notstarted) 
    {
      return redirect()->back()
        ->with('message', '本日まだ出勤打刻を完了していません');
    } 
    elseif ($alreadyfinished) 
    {
      return redirect()->back()
        ->with('message', '本日すでに退勤打刻を完了しています');
    } 
    elseif (isset($target->start_rest) || isset($target->finished_rest)) 
    {
      
      if ($target->start_rest > $target->finished_rest) {
        $total_work = $target->start_at->diffInSeconds($finish_work);
        $start_rest = $target->start_rest;
        $this_rest = $start_rest->diffInSeconds($finish_work);
        $total_rest = $this_rest + $target->total_rest;

        $target->update([
          'finished_at' => $finish_work,
          'total_work' => $total_work,
          'finished_rest' => $finish_work,
          'total_rest' => $total_rest,
        ]);
        return redirect()->back()
          ->with('message', '休憩を終了し、退勤打刻が完了しました');
      }
      else
      {
        $total_work = $target->start_at->diffInSeconds($finish_work);
        $target->update([
          'finished_at' => $finish_work,
          'total_work' => $total_work,
        ]);
        return redirect()->back()
        ->with('message', '退勤打刻が完了しました');

      }
    } 
    elseif ($target) 
    {
      $total_work = $target->start_at->diffInSeconds($finish_work);
      $target->update([
        'finished_at' => $finish_work,
        'total_work' => $total_work,
      ]);
      return redirect()->back()
        ->with('message', '退勤打刻が完了しました');
    }
    else{
      return redirect()->back()
      ->with('message', 'エラーが発生しました');;
    }
  }

  public function startrest()
  {
    $user = Auth::user();
    $start_rest = Carbon::now();
    $target = Work::whereDate('start_at', $start_rest)->where('user_id', $user->id)->where('finished_at', null)->where('start_rest', null)->where('finished_rest', null)->first();
    $work_notstarted = Work::whereDate('work_on', $start_rest)->where('user_id', $user->id)->first() == null;
    $work_alreadyfinished = Work::whereDate('finished_at', $start_rest)->where('user_id', $user->id)->first();
    $rest_alreadystarted = Work::whereDate('start_rest', $start_rest)->where('user_id', $user->id)->where('finished_rest', null)->first();
    $rest_another = Work::whereDate('finished_rest', $start_rest)->where('user_id', $user->id)->where('finished_at', null)->first();
    $overnight = Work::whereDate('start_at', !$start_rest)->where('user_id', $user->id)->where('finished_at', null)->first();
    if ($work_notstarted) 
    {
      dd('a');
      return redirect()->back()
        ->with('message', '本日まだ出勤打刻を完了していません');
    } 
    elseif ($work_alreadyfinished) 
    {
      dd('b');
      return redirect()->back()
        ->with('message', '本日すでに退勤打刻を完了しています');
    } 
    elseif($overnight)
    {

    }
    elseif ($target) 
    {
      $target->update([
        'start_rest' => $start_rest,
      ]);
      return redirect()->back()
        ->with('message', '休憩を開始しました');
    }
    elseif ($rest_alreadystarted) 
    {
      return redirect()->back()
        ->with('message', 'すでに休憩を開始しています');
    } 
    elseif($rest_another){
      if ($rest_another->start_rest > $rest_another->finished_rest) 
      {
        return redirect()->back()
          ->with('message', 'すでに休憩を開始しています');
      } 
      elseif ($rest_another->start_rest < $rest_another->finished_rest) 
      {
        $rest_another->update([
          'start_rest' => $start_rest,
        ]);
        return redirect()->back()
          ->with('message', '休憩を再び開始しました');
      }
    }
    else
    {
      return redirect()->back()
        ->with('message', '予期せぬエラーが発生しました');
    }
  }

  public function finishrest()
  {
    $user = Auth::user();
    $finish_rest = Carbon::now();
    $target = Work::whereDate('start_at', $finish_rest)->where('user_id', $user->id)->where('finished_at', null)->first();
    $work_notstarted = Work::whereDate('work_on', $finish_rest)->where('user_id', $user->id)->first() == null;
    $work_alreadyfinished = Work::whereDate('finished_at', $finish_rest)->where('user_id', $user->id)->first();

    if ($work_notstarted) {
      return redirect()->back()
        ->with('message', '本日まだ出勤打刻を完了していません');
    } elseif ($work_alreadyfinished) {
      return redirect()->back()
        ->with('message', '本日すでに退勤打刻を完了しています');
    } elseif (empty($target['start_rest']) || $target->start_rest < $target->finished_rest) {
      return redirect()->back()
        ->with('message', '休憩が開始されていません');
    } elseif ($target || $target->start_rest > $target->finished_rest) {
      $this_rest = $target->start_rest->diffInSeconds($finish_rest);
      $total_rest = $this_rest + $target->total_rest;
      $target->update([
        'finished_rest' => $finish_rest,
        'total_rest' => $total_rest,
      ]);
      return redirect()->back()
        ->with('message', '休憩を終了しました');
    }
  }

  public function showdate(REQUEST $Request)
  {
    // 前日ボタン押したら
    if ($Request->before == "before") {
      $users = User::get();
      $last_day = date('Y-m-d', strtotime($Request->day . '-1 day'));
      $dates = Work::latest('finished_at')->where('work_on', $last_day)->paginate(5);
      $day = $last_day;
      Date::first()->update([
        'target' => $last_day,
      ]);

      return view('date', compact('users', 'dates', 'day'))->with('message', 'POSTあり');
    }
    // 翌日ボタン押したら
    elseif ($Request->after == "after") {
      $users = User::get();
      $next_day = date('Y-m-d', strtotime($Request->day . '1 day'));
      $dates = Work::latest('finished_at')->where('work_on', $next_day)->paginate(5);
      $day = $next_day;
      Date::first()->update([
        'target' => $next_day,
      ]);

      return view('date', compact('users', 'dates', 'day'))->with('message', 'POSTなし');
    }
    // ページリクエストがあったら ※ページネーションのリロード対策
    elseif ($Request->page) {
      $users = User::get();
      $day = Date::first()->target;
      $dates = Work::latest('finished_at')->where('work_on', $day)->paginate(5);

      return view('date', compact('users', 'dates', 'day'))->with('message', '今日');
    }
    // ページリクエストがなかったら　//一発目/dateに来た時
    elseif ($Request->page == null) {
      $users = User::get();
      $day = Carbon::today()->format('Y-m-d');
      //ページめくった後に戻ってきたパターン
      if (Date::first()) {
        Date::first()->update([
          'target' => $day,
        ]);
      }
      //初めて/dateに来たパターン（テーブルにデータがない）
      elseif (Date::first() == null) {
        Date::create([
          'target' => $day,
        ]);
      }
      $dates = Work::latest('finished_at')->where('work_on', $day)->paginate(5);
      return view('date', compact('users', 'dates', 'day'))->with('message', '今日');
    }
  }
  public function users(REQUEST $request)
  {
    
    //検索した場合
    if($request->keyword)
    {
      $users = User::KeywordSearch($request->keyword)->paginate(5);
      //
      if(empty(Keyword::first())){
        Keyword::create([
          'keyword' => $request->keyword,
        ]);
      }
      else{
        Keyword::first()->update([
          'keyword' => $request->keyword,
        ]);
      }
      
      return view('users', compact('users'));
    } 
    //ページネーションクリック場合
    elseif ($request->page) 
    {
      $keyword = Keyword::first()->keyword;
      $users = User::KeywordSearch($keyword)->paginate(5);
      return view('users', compact('users'));
    }
    //初めて/usersに来たパターン
    else 
    {
      $users = User::paginate(5);
      return view('users', compact('users'));
    }
  }

  public function parsonal(REQUEST $request)
  {

    if ($request->serch) {
      $user_id = $request->user_id;
      $user_name = $request->user_name;
      $records = work::where('user_id', $request->user_id)->paginate(5);
      return view('parsonal', compact('records', 'user_name', 'user_id'));
    }
    elseif ($request->year) {
      $user_id = $request->user_id;
      $user_name = $request->user_name;
      $target_date = Carbon::create($request->year, $request->month, 1, null, null, null);
      $records= work::where('user_id', $request->user_id)->whereMonth('start_at', $target_date)->paginate(5);
      $year = $request->year;
      $month = $request->month;
      return view('parsonal', compact('records', 'user_name', 'user_id', 'year', 'month'));
    }
    else{
      $user_id = $request->user_id;
      $user_name = $request->user_name;
      $records = work::where('user_id', Auth::user()->id)->paginate(5);
      return view('parsonal', compact('records', 'user_name', 'user_id',));
    }
  }
}
