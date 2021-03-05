<?php

namespace App\Console\Commands;

use App\Jobs\RecalculateAge;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class RunCalculateAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calculateAge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //$schedule->job(new RecalculateAge)->timezone('Europe/Moscow')->dailyAt('03:00')->withoutOverlapping() ;
        RecalculateAge::dispatchNow();
    }
}
