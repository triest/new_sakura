<?php

    namespace App\Http\Controllers\Lk;

    use App\Http\Controllers\Controller;
    use App\Models\Interest;
    use App\Models\Lk\Purchase;
    use App\Models\Target;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;

    class HomeController extends Controller
    {

        // создание каталогов
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

        public function profile(Request $request)
        {
            $user = $request->user('lk');

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


        //    $user->getAge();
            return view('lk.profile.index')->with([
                    'user' => $user,
                    'targets' => $target,
                    'interests' => $interst,
                    'size' => $size,
                    'anketTarget' => $anketTarget,
                    'anketInterests' => $anketInterest,
            ]);
        }

        public function store_profile(Request $request)
        {

            $validatedData = $request->validate([
                    'name' => 'required',
                    'date_birth' => 'date',
                    'description' => 'required'
            ]);


            $user = Auth::user();
            $data = $request->all();
            $user->fill($data);
            $user->description = $request->description;
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


            $user->save();
            return redirect('lk/profile');
        }

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
