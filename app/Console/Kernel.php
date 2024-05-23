<?php

namespace App\Console;

use App\Helper\Cron\RankBonus;
use App\Helper\Cron\SetUserRank;
use App\Helper\Cron\ExpireMembers;
use App\Helper\Cron\DailyBonusCron;
use App\Helper\Cron\FounderBonusCron;
use App\Helper\Cron\GenerationBonusAdd;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {

        //     FounderBonusCron::runSchedule();

        //     SetUserRank::runSchedule();

        //     RankBonus::runSchedule();

        //     DailyBonusCron::runSchedule();

        //     ExpireMembers::runSchedule();


        // })
        //     // ->everyFourHours()
        //     ->everyMinute()
        //     ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
