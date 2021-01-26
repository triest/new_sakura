<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserProfile;
use App\Jobs\BlurImageJob;
use App\Models\Interest;
use App\Models\Lk\Purchase;
use App\Models\Relation;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Facades\Image;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Exception\IOException;

class HomeController extends Controller
{

    // создание каталогов
    /**
     * @param string $patch
     * @return bool
     */
    function _create_dir($patch = '')
    {
        if (empty($patch)) {
            return false;
        }

        $dir = explode('/', $patch);
        $pp = '';
        foreach ($dir as $k => $v) {
            if ($k) {
                $pp .= '/';
            }

            $pp .= $v;
            if (!file_exists($pp)) {
                mkdir($pp);
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return redirect('lk/profile')->with(compact($user));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        //  $user = $request->user('lk');
        $user = Auth::user();
        if (!$user) {
            return redirect('/');
        }

        if ($user->profile_url != '') {
            $fileName = $user->profile_url;
            $fileName = base_path() . $fileName;
            if (file_exists($fileName)) {
                $size = filesize($fileName) / 1024;
                $size = intval($size);
            } else {
                $size = '';
            }
        } else {
            $size = '';
        }

        //
        $target = Target::select(['*'])->get();
        $interst = Interest::select(['*'])->get();


        $targets = $user->target()->get();
        $anketTarget = [];
        foreach ($targets as $tag) {
            array_push($anketTarget, $tag->id);
        }

        $interests = $user->interest()->get();

        $anketInterest = [];
        foreach ($interests as $item) {
            array_push($anketInterest, $item->id);
        }

        $relations = Relation::select(['*'])->get();


        //    $user->getAge();
        return view('lk.profile.index')->with(
                [
                        'user' => $user,
                        'targets' => $target,
                        'interests' => $interst,
                        'size' => $size,
                        'anketTarget' => $anketTarget,
                        'anketInterests' => $anketInterest,
                        'relations' => $relations
                ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store_profile(StoreUserProfile $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }
        $data = $request->all();
        $user->fill($data);

        if ($request->hasFile('file-upload-photo-profile')) {
            if ($user->photo_profile != null) {
                Storage::delete($user->photo_profile);
            }
            $path = $request->file('file-upload-photo-profile')->store('public/profile');
            $user->photo_profile_url = 'storage/app/' . $path;
            $user->photo_profile = $path;
            /*
             * теперь блур
             * */
            $file = $request->file('file-upload-photo-profile');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('uploads/logos/', $filename);
            BlurImageJob::dispatch($filename,$user)->delay(now()->addMinutes(10));;


        }

        $user->save();
        $user->target()->detach();
        if ($request->has('target')) {
            foreach ($request->target as $item) {
                $target = Target::select(['id', 'name'])->where('id', $item)
                        ->first();
                if ($target != null) {
                    $user->target()->attach($target);
                }
            }
        }
        $user->interest()->detach();
        if ($request->has('interest')) {
            foreach ($request->interest as $item) {
                $interestt = Interest::select(['id', 'name'])->where('id', $item)
                        ->first();
                if ($interestt != null) {
                    $user->interest()->attach($interestt);
                }
            }
        }


        return redirect('lk/profile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_crop(Request $request)
    {
        $user = Auth::user();
        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        $name = md5(microtime(true));;
        $midle_path = '/public/upload/lk_profile/' . $user->id;
        $midle_path2 = '/upload/lk_profile/' . $user->id;
        $patch = base_path() . $midle_path;

        $patch = str_replace('\\', '/', $patch);
        $this->_create_dir($patch);

        $fileName = $patch . "/" . $name . ".png";

        file_put_contents($fileName, $fileData);

        file_put_contents($fileName, $fileData);
        $user->profile_url = $midle_path2 . '/' . $name . ".png";

        $user->save();

        $size = filesize($fileName) / 1024;
        $size = ceil($size);

        return response()->json(["url" => $midle_path2 . "/" . $name . ".png", 'size' => $size]);
    }


}
