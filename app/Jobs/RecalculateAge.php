<?php

namespace App\Jobs;

use App\Models\Lk\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateAge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $users = User::select(['id', 'age', 'date_birth'])->notNull(['date_birth'])->get();

        foreach ($users as $user) {
            $age = $user->getAge();
            if ($age) {
                $user->age = $age;
                $user->save();
            }
        }
    }
}
