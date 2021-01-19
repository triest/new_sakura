<?php

namespace App\Observers;

use App\Models\Lk\User;

use Carbon\Carbon;
use DateTimeZone;
use Symfony\Component\Filesystem\Exception\IOException;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param App\Models\Lk\User;  $user
     * @return void
     */
    public function created(User $user)
    {
        try {
            $dateBith = $user->date_birth;
            if(!$dateBith){
                return;
            }
            $mytime = Carbon::now();
            $last_login = Carbon::createFromFormat('Y-m-d', $dateBith);
            $dateBith = Carbon::instance($mytime);
            //    $datediff = date_diff($last_login, $mytime);
            $user->age = $dateBith->diffInYears($last_login);
            $user->save();
        } catch (IOException $exception) {
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param App\Models\Lk\User;  $user
     * @return void
     */
    public function updated(User $user)
    {
        try {
            $dateBith = $user->date_birth;
            if(!$dateBith){
                return;
            }
            $mytime = Carbon::now();
            $last_login = Carbon::createFromFormat('Y-m-d', $dateBith);
            $dateBith = Carbon::instance($mytime);
            //    $datediff = date_diff($last_login, $mytime);
            $user->age = $dateBith->diffInYears($last_login);
            $user->save();
        } catch (IOException $exception) {
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param App\Models\Lk\User;  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param App\Models\Lk\User;  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
        $dateBith = $user->date_birth;
        $mytime = Carbon::now();
        $last_login = Carbon::createFromFormat('Y-m-d', $dateBith);
        $datediff = date_diff($last_login, $mytime);
        $user->save();
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param App\Models\Lk\User; $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
