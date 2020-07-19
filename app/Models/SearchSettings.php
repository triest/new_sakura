<?php

    namespace App\Models;

    use App\Http\Controllers\AnketController;
    use App\Models\Lk\User;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cookie;

    class SearchSettings extends Model
    {
        //
        //
        protected $table = "seach_settings";

        public function girl()
        {
            return $this->belongsTo(User::class);
        }

        public function target()
        {
            return $this->belongsToMany(Target::class, 'search_target',
                    'search_id', 'target_id');
        }

        public function interest()
        {
            return $this->belongsToMany(Interest::class, 'search_interest',
                    'search_id',
                    'interest_id');
        }

        public static function getSeachSettings()
        {
            $cookie = null;
            $userAuth = Auth::user();
            if ($userAuth != null) {
                $user = User::select(['id', 'name'])
                        ->where('id', $userAuth->id)->first();

                //сли не авторизован, то смотрим по кукам.
                if ($user != null) {


                    $seachSettings = $user->seachsettings()->first();

                    if ($seachSettings != null) {
                        return $seachSettings;
                    } else {
                        $seachSettings = new SearchSettings();
                        $seachSettings->save();
                        $user->seachsettings()->save($seachSettings);

                        return $seachSettings;
                        //   $anket->target()->attach($seachSettings);
                    }
                } else {
                    if (!isset($_COOKIE["seachSettings"])) {
                        $_COOKIE["seachSettings"] = AnketController::randomString(64);
                    }
                    $cookie = $_COOKIE["seachSettings"];
                    $seachSettings = SearchSettings::select(['*'])
                            ->where("cookie", "=", $cookie)
                            ->orderBy('created_at', 'desc')
                            ->first();
                    if ($seachSettings != null) {
                        return $seachSettings;
                    }
                }
            } else {


                if (isset($_COOKIE["seachSettings"])
                        && $_COOKIE["seachSettings"] != null
                ) {
                    $seachSettings = SearchSettings::select([
                            '*'
                    ])
                            ->orderBy('created_at', 'desc')
                            ->where("cookie", "=", $_COOKIE["seachSettings"])->first();

                    if ($seachSettings == null) {

                        $seachSettings = new SearchSettings();
                        $seachSettings->cookie = $_COOKIE["seachSettings"];
                        $seachSettings->save();

                        return $seachSettings;
                    }

                    return $seachSettings;
                } else {

                    $cookie = AnketController::randomString(100);
                    $seachSettings = new SearchSettings();
                    $seachSettings->cookie = $cookie;
                    $seachSettings->save();
                    Cookie::queue("seachSettings", $cookie, 6000);

                    return $seachSettings;
                }
            }

            return null;
        }
    }
