<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\Present;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use Ramsey\Uuid\Generator\PeclUuidRandomGenerator;
    use Illuminate\Support\Facades\Input;

    class AdminUsersController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
//        $this->middleware('auth');
        }

        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Contracts\Support\Renderable
         */
        public function index()
        {

            return view('admin.home');
        }


        public function lesson()
        {
            return view('home.lesson');
        }

        public function presentsMain()
        {
            return view('admin.presents.main');
        }

        public function presentsList(Request $request)
        {
            $presents = Present::select('*')->get();
            return response()->json([
                    'presents' => $presents
            ]);
        }

        public function storePresent(Request $request)
        {

            if ($request->has('present')) {
                $present = Present::select(['*'])->where('id', intval($request->present))->first();
            } else {
                $present = new Present();
            }


            $present->name = $request->name;
            $present->price = intval($request->price);

            //  dump($request);
            if ($request->enable == "true") {
                $present->enabled = 1;
            } else {

                $present->enabled = 0;
            }
            $present->save();

            if ($request->hasFile('file')) {


                $image_new_name = md5(microtime(true));
                $path = $request->file('file')->store('public/presents');
                $present->image_url = 'storage/app/' . $path;
                $present->image = $image_new_name;
                $present->save();
            }
            $present->save();

            return response()->json([
                    'present' => $present
            ]);
        }
    }
