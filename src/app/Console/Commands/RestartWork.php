<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\User;
use Carbon\Carbon;

class RestartWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RestartWork';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '日付跨いだら出勤操作へ切替';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger('batch starts');
        logger('batch processing');
        $now = Carbon::now();
        $tomorrow = Carbon::tomorrow();
        $targets = Work::whereDate('work_on', Carbon::now())->where('finished_at', null)->get();
        $count = 0;
        
        foreach ($targets as $target) 
        {
             /*休憩終了忘れがいる場合 */
            if($target)
            {
                logger('anyone forgot');
                /*休憩を一度でも開始している場合 */
                if (isset($target->start_rest) || isset($target->finished_rest)) {

                    /*休憩を再び開始し、休憩終了していない場合 */
                    if ($target->start_rest > $target->finished_rest) {
                        $total_work = $target->start_at->diffInSeconds($now);
                        $start_rest = $target->start_rest;
                        $this_rest = $start_rest->diffInSeconds($now);
                        $total_rest = $this_rest + $target->total_rest;

                        $target->update([
                            'finished_at' => $now,
                            'total_work' => $total_work,
                            'finished_rest' => $now,
                            'total_rest' => $total_rest,
                        ]);
                        Work::create([
                            'user_id' => $target->user_id,
                            'start_at' => $tomorrow,
                            'work_on' => $tomorrow,
                        ]);
                    }
                    /*休憩を再び開始し、休憩終了している場合 */ 
                    else 
                    {
                        $total_work = $target->start_at->diffInSeconds($now);
                        $target->update([
                            'finished_at' => $now,
                            'total_work' => $total_work,
                        ]);
                        Work::create([
                            'user_id' => $target->user_id,
                            'start_at' => $tomorrow,
                            'work_on' => $tomorrow,
                        ]);
                    }
                }
                /*休憩を一度もしていない場合 */ 
                elseif ($target) 
                {
                    $total_work = $target->start_at->diffInSeconds($now);
                    $target->update([
                        'finished_at' => $now,
                        'total_work' => $total_work,
                    ]);
                    Work::create([
                        'user_id' => $target->user_id,
                        'start_at' => $tomorrow,
                        'work_on' => $tomorrow,
                    ]);
                } 
                else 
                {
                    logger('error');
                }
                ++$count;
                logger('target 1'. $count .'processing');
            }
            /*休憩終了忘れがいない場合 */
            else
            {
                logger('no one forgot for today');
            }
        }
        logger('batch finished');
    }
}
