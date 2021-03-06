<?php

namespace App\Jobs;

use App\Mail\CompaniesMail;
use App\Mail\SendMessageNotification;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        //
        $this->message=$message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // проверяем, онлайн ли поьзователь
        if($user=$this->message->toContact()->first()){
            if($user && !$user->isOnline()){
                Mail::to($user->email)->send(new SendMessageNotification($this->message));
            }
        }
    }
}
