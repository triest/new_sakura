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
        $user->age=$user->getAge();
    }

    /**
     * Handle the user "updated" event.
     *
     * @param App\Models\Lk\User;  $user
     * @return void
     */
    public function saving(User $user)
    {
        if ($user->age != $user->getOriginal('age')) {
            $user->age=$user->getAge();
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
