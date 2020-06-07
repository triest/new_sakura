<?php

    namespace App\Http\Controllers\Lk;

    use App\Http\Controllers\Controller;
    use App\Models\Lk\Purchase;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;

    class HomeController extends Controller
    {

        // создание каталогов
        function _create_dir($patch = '') {
            if(empty($patch)) {
                return false;
            }

            $dir = explode('/', $patch);
            $pp = '';
            foreach($dir as $k => $v) {
                if($k) {
                    $pp .= '/';
                }

                $pp .= $v;
                if(! file_exists($pp)) {
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

            return view('lk.profile.index', ['user' => $user, "size" => $size]);
        }

        public function store_profile(Request $request)
        {

            $validatedData = $request->validate([
                    'last_name' => 'required',
                    'first_name' => 'required',
                    'middle_name' => 'required',
                    'position' => 'required',
                    'name_company' => 'required',
                    'phone' => 'required|numeric',
                    'job_phone' => 'numeric',
                    'contact_email' => 'required|email',
                    'work_email' => 'email',
                    'inn' => 'required|max:255|min:10',
                    'education' => 'required',
                    'date_birth' => 'required|string',
                    'file-upload-photo-profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3072',
                    'file-upload-doc' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3072',
                    'file-upload-photo' => 'image|mimes:jpeg,png,jpg|max:3072',

            ]);

            $user = Auth::user();
            $data = $request->all();
            $user->fill($data);
            $user->save();

            if ($request->file('file-upload-photo-profile') != null) {

                $file = $request->file('file-upload-photo-profile')->getClientOriginalName();
                $temp = explode('.', $file);
                $name = 'profile' . '.' . $temp[1];
                $midle_path = '/public/upload/lk_profile/' . $user->id;
                $patch = base_path() . $midle_path;
                //проверка на чушествование папки
                $patch .= '/';
                $request->file('file-upload-photo-profile')
                        ->move($patch, strtolower($name));
                $user->profile_url = $midle_path . '/' . $name;
                $user->save();
            }

            if ($request->file('file-upload-doc') != null) {
                $file = $request->file('file-upload-doc')->getClientOriginalName();
                $temp = explode('.', $file);
                $name = 'doc' . '.' . $temp[1];
                $midle_path = '/public/upload/lk_profile/' . $user->id;
                $patch = base_path() . $midle_path;
                //проверка на чушествование папки
                $patch .= "/";
                $request->file('file-upload-doc')
                        ->move($patch, strtolower($name));
                $user->doc_url = $midle_path . '/' . $name;
            }

            if ($request->file('file-upload-photo') != null) {
                $file = $request->file('file-upload-photo')->getClientOriginalName();
                $temp = explode('.', $file);

                $name = 'photo' . '.' . $temp[1];
                $midle_path = '/public/upload/lk_profile/' . $user->id;
                $patch = base_path() . $midle_path;
                //проверка на чушествование папки
                $patch .= '/';
                $request->file('file-upload-photo')
                        ->move($patch, strtolower($name));
                $user->photo_url = $midle_path . '/' . $name;
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
            $name =  md5(microtime(true));;
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
