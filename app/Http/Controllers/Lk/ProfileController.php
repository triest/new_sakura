<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserProfile;
use App\Jobs\BlurImageJob;
use App\Models\Interest;
use App\Models\Relation;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {
        $user = Auth::user();


        if (!$user) {
            return redirect('login');
        }

        if(!$user->photo_profile){
            if(!$request->hasFile('file-upload-photo-profile')){
                back()->with('photo-error','Добавитe фотографию!')->withInput();
            }
        }
        
        $user->fill($request->all());

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
