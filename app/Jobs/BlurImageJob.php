<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Symfony\Component\Filesystem\Exception\IOException;

class BlurImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image, $user)
    {
        $this->image = $image;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
            $image2 = new Imagick(public_path() . '/uploads/logos/' . $this->image);
            $path_parts = pathinfo($this->image);
            $image2->blurImage(100, 100);
            $filename = $path_parts['filename'] . uniqid(rand()) . "." . $path_parts['extension'];
            file_put_contents(public_path() . '/uploads/logos/' . $filename, $image2);

            if ($this->user->blur_photo_profile_url != null) {
                Storage::delete($this->user->blur_photo_profile);
            }
            $rez = Storage::put('public/profile/' . $filename, $image2);
            // сохраняем картинку
            $this->user->blur_photo_profile_url = 'storage/app/public/profile/' . $filename;
            $this->user->blur_photo_profile = 'public/profile/' . $filename;
            $this->user->save();
        } catch (IOException $exception) {
        }
    }
}
