<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        //
        $this->message=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $image_url=request()->getSchemeAndHttpHost().'/'.$this->message->fromContact()->first()->photo_profile_url;
        $form=$this->message->fromContact()->first();
        return $this->view('mails.newMessage')->with(["message"=>$this->message,"image_url"=>$image_url,'from'=>$form]);
    }
}
