<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imagick;
use Symfony\Component\Filesystem\Exception\IOException;

class BlurImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->image = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
     //   $image = imagecreatefromjpeg('uploads/logos/'.$this->image);
       // dump($image); die();
        try {
            $image2 = new Imagick(public_path().'/uploads/logos/'.$this->image);

            $path_parts = pathinfo($this->image);

            $image2->blurImage(100,100);
            file_put_contents (public_path().'/uploads/logos/'. $path_parts['filename'].".".$path_parts['extension'], $image2);

        } catch (IOException $exception) {
        }
    }
}
