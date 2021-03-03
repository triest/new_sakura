<?php

namespace App\Models\Lk;

use App\Models\Album;
use App\Models\City;
use App\Models\Dialog;
use App\Events\NewMessage;
use App\Models\Event;
use App\Models\EventRequest;
use App\Models\GiftAct;
use App\Models\Interest;
use App\Models\Like;
use App\Models\Message;
use App\Models\Relation;
use App\Models\SearchSettings;
use App\Models\Target;
use App\Models\Visit;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\Models\Present;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\SluggableScopeHelpers;
use Carbon\Carbon;
use Composer\Util\Git;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Lk\User
*/
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;
    use HasTranslations;

    protected $table = 'users';

    protected $translatable = ['slug'];


    protected $guard = 'lk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name',
            'surname',
            'active',
            'email',
            'work_email',
            'contact_email',
            'phone',
            'password',
            'name_company',
            'job_phone',
            'position',
            'first_name',
            'last_name',
            'middle_name',
            'education',
            'inn',
            'date_birth',
            'description',
            'sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            'password',
            'remember_token',
            'inn',
            'work_email',
            'contact_email',
            'email',
            'phone',
            'private',
            'banned',
            'begin_vip',
            'created_at',
            'description'
    ];

    public $appends=['age'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
            'email_verified_at' => 'datetime',
    ];

    /**
     * Возвращает полное имя по full_name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return collect([$this->name, $this->surname])->join(' ');
    }

    /**
     * Переопределение отправки письма поддтверждения почты
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * Переопределение ссылки для сброса пароля
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function target()
    {
        return $this->belongsToMany(
                Target::class,
                'user_target',
                'user_id',
                'target_id'
        );
    }

    public function interest()
    {
        return $this->belongsToMany(
                Interest::class,
                'user_interest',
                'user_id',
                'interest_id'
        );
    }


    public function getAge()
    {
        $dateBith = $this->date_birth;
        $mytime = Carbon::now();
        $last_login = Carbon::createFromFormat('Y-m-d', $dateBith);
        $datediff = date_diff($last_login, $mytime);
        return $datediff->y;
    }


    public static function get($id, $all = false)
    {
        if ($all == false) {
            return User::select(
                    [
                            'id',
                            'name',
                            'description',
                            'sex',
                            'weight',
                            'height',
                            'meet',
                            'banned',
                            'country_id',
                            'region_id',
                            'city_id',
                            'date_birth',
                            'last_login',
                            'relation_id',
                            'photo_profile_url'
                    ]
            )->where('id', $id)->first();
        } else {
            return User::select(['*'])->where('id', $id)->first();
        }
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'target_id', 'id');
    }

    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }


    public static function Ipstatic()
    {
        foreach (
                array(
                        'HTTP_CLIENT_IP',
                        'HTTP_X_FORWARDED_FOR',
                        'HTTP_X_FORWARDED',
                        'HTTP_X_CLUSTER_CLIENT_IP',
                        'HTTP_FORWARDED_FOR',
                        'HTTP_FORWARDED',
                        'REMOTE_ADDR',
                ) as $key
        ) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var(
                                    $ip,
                                    FILTER_VALIDATE_IP,
                                    FILTER_FLAG_NO_PRIV_RANGE
                                    | FILTER_FLAG_NO_RES_RANGE
                            ) !== false
                    ) {
                        return $ip;
                    }
                }
            }
        }

        return null;
    }


    public function seachsettings()
    {
        return $this->hasOne(SearchSettings::class);
    }


    public function age()
    {
        $now = Carbon::now();
        if ($this->date_birth == null) {
            return null;
        }
        $data = Carbon::createFromDate($this->date_birth);
        $year = (date_diff($now, $data));
        return $year->y;
    }

    public function getAgeAttribute(){
        $now = Carbon::now();
        if ($this->date_birth == null) {
            return null;
        }
        $data = Carbon::createFromDate($this->date_birth);
        $year = (date_diff($now, $data));
        return $year->y;
    }


    public function isOnline()
    {
        return \Cache::has('user-is-online-' . $this->id);
    }

    public function lastLoginFormat()
    {
        $last_login = $this->last_login;
        if ($this->last_login == null) {
            return "";
        }
        $mytime = Carbon::now();
        $last_login = Carbon::createFromFormat('Y-m-d H:i:s', $last_login);
        $datediff = date_diff($last_login, $mytime);
        if ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0) {
            if ($datediff->h < 1) {
                $last_login = "менее часа назад";
            } elseif ($datediff->h == 1) {
                $last_login = "час назад";
            } elseif (($datediff->h > 1 && $datediff->h <= 4)
                    || ($datediff->h >= 22 && $datediff->h <= 23)
            ) {
                $last_login = $datediff->h . " часа назад";
            } elseif ($datediff->h >= 5 && $datediff->h <= 20) {
                $last_login = $datediff->h . " часов назад";
            } elseif ($datediff->h == 21) {
                $last_login = $datediff->h . " час назад";
            }
        } elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d > 0) {
            if ($datediff->d == 1) {
                $last_login = "вчера";
            } elseif ($datediff->d < 7) {
                $last_login = $datediff->d . " дня назад";
            } elseif ($datediff->d >= 7 && $datediff->d <= 13) {
                $last_login = "неделю назад";
            } elseif ($datediff->d > 13 && $datediff->d < 21) {
                $last_login = "две недели назад";
            } elseif ($datediff->d >= 21) {
                $last_login = "три недели назад";
            }
        } elseif ($datediff->y == 0 && $datediff->m == 1) {
            $last_login = "месяц назад";
        } elseif ($datediff->y == 0 && $datediff->m > 1) {
            $last_login = $datediff->m . "месяцев назад";
        } elseif ($datediff->y >= 1) {
            $last_login = "давно";
        }

        return $last_login;
    }

    public function newLike($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }
        $result = [];

        if ($user == null) {
            $result['result'] = false;
            $result['message'] = "not auth";
            return $result;
        }


        $user = User::get($user->getAuthIdentifier());
        if ($user == null) {
            $result['result'] = false;
            $result['message'] = "not auth";
            return $result;
        }


        $like = new Like();
        $like->target_id = $this->id;
        $like->who_id = $user->id;
        $like->save();


        /*
         * ищим поставил ли он вам дфйк
         * */

        $first = Like::select(['id'])->where('who_id', $this->id)
                ->where('target_id', $user->id)->first();

        if ($first) {
            $user->sendMessage("Мы понравились друг другу ");
            $this->sendMessage("Мы понравились друг другу ");
            $result['message'] = "Мы понравились друг другу";
            $result['result'] = true;
            $result['match'] = true;
        } else {
            $result['message'] = "";
            $result['result'] = true;
            $result['match'] = false;
        }
        return $result;
    }

    /*проверяет, что пользователь переданный ф функцию, поставил лайк пользователю, чей метод вызываеться*/
    public function checkLike(User $user){
        $first = Like::select(['id'])->where('target_id', $this->id)
                ->where('who_id', $user->id)->first();
        if($first==null){
            return false;
        }else{
            return true;
        }
    }

    public function sendMessage($text, $who_user = null)
    {
        $TargetUser = $this;


        if ($who_user == null) {
            $user = Auth::user();
        }

        if ($user == null || $TargetUser == null) {
            return false;
        }
        /*
                    $message = Message::create([
                            'from' => $user->id,
                            'to' => $TargetUser->id,
                            'text' => $text,
                    ]);*/
        $message = new Message();
        $message->to = $user->id;
        $message->from = $TargetUser->id;
        $message->text = $text;
        $message->save();

        $id2 = $TargetUser->id;
        $dialog = Dialog::select(['id', 'my_id', 'other_id'])
                ->where('my_id', $user->id)->where(
                        'other_id',
                        $id2
                )->first();
        if ($dialog == null) {
            $dialog3 = new Dialog();
            $dialog3->my_id = $user->id;
            $dialog3->other_id = $id2;
            $dialog3->lastMessage=Carbon::now();
            $dialog3->save();
        }else{
            $dialog->lastMessage=Carbon::now();
            $dialog->save();
        }
        $dialog2 = Dialog::select(['id', 'my_id', 'other_id'])
                ->where('other_id', $user->id)->where(
                        'my_id',
                        $id2
                )->first();
        if ($dialog2 == null) {
            $dialog4 = new Dialog();
            $dialog4->other_id = $user->id;
            $dialog4->my_id = $id2;
            $dialog4->lastMessage=Carbon::now();
            $dialog4->save();
        }else{
            $dialog2->lastMessage=Carbon::now();
            $dialog2->save();
        }
        broadcast(new NewMessage($message));

        return $message;
    }

    public function makeGift($present_id,$text=null)
    {
        $giftAct = new GiftAct();
        $auth_user = Auth::user();
        if ($auth_user == null) {
            return false;
        }
        $present = Present::get(intval($present_id));
        if ($present == null) {
            return false;
        }

        $giftAct->target_id = $this->id;
        $giftAct->who_id = $auth_user->id;
        $giftAct->present_id = $present->id;
        $giftAct->comment=$text;
        $giftAct->save();
        return true;
    }

    public function getGifts($limit = 5)
    {
        return GiftAct::select(['*'])->with('who','gift')->where(['target_id' => $this->id])->get();
    }

    public function getGiftForMe()
    {
        return $this->hasMany(GiftAct::class, 'target_id', 'id');
    }


    public function getCity()
    {
        if ($this->city_id != null) {
            return $city = City::get($this->city_id);
        } else {
            return null;
        }
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function sluggable(): array
    {
        return [
                'slug' => [
                        'source' => 'slug_or_name',
                ],
        ];
    }


    public static function getIpstatic()
    {
        foreach (
                array(
                        'HTTP_CLIENT_IP',
                        'HTTP_X_FORWARDED_FOR',
                        'HTTP_X_FORWARDED',
                        'HTTP_X_CLUSTER_CLIENT_IP',
                        'HTTP_FORWARDED_FOR',
                        'HTTP_FORWARDED',
                        'REMOTE_ADDR',
                ) as $key
        ) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var(
                                    $ip,
                                    FILTER_VALIDATE_IP,
                                    FILTER_FLAG_NO_PRIV_RANGE
                                    | FILTER_FLAG_NO_RES_RANGE
                            ) !== false
                    ) {
                        return $ip;
                    }
                }
            }
        }

        return null;
    }

    public function getEventRequests($OnlyUnread = false)
    {
        /* */
        $eventReq = EventRequest::select(["*"])
                ->select(
                        [
                                '*'
                        ]
                )
                ->where('user_id', '=', $this->id)
                ->with(['user', 'event']);

        if ($OnlyUnread) {
            $eventReq->where(['event_request.status_id' => 1]);
        }



        return $eventReq;
    }

    public function getMyEventRequest($OnlyUnread = false)
    {
        $eventReq = EventRequest::select(["*"])
                ->select(
                        ['*']
                )->where(['user_id' => $this->id]);

        if ($OnlyUnread) {
            $eventReq->where(['readed', 0])->where(['status', '!=', 'unreaded']);
        }

        return $eventReq;
    }


    public function messagesForMe()
    {
        return $this->hasMany(Message::class, 'to', 'id');
    }

    public function dialogs()
    {
            return $this->hasMany(Dialog::class,'my_id','id');
    }

    public function whoVisit(){
        return $this->hasMany(Visit::class,'who_id','id');
    }

    public function targetVisit(){
        return $this->hasOne(Visit::class);
    }

    public function saveVisit(){
         $authUser=Auth::user();

         $authUser=User::select(['*'])->where(['id'=>$authUser->id])->first();
        if($authUser==null){
            return;
        }

         $visit=new Visit();
         $visit->target()->associate($this);
         $visit->who()->associate($authUser);
        $visit->save();
    }

    public function getVisits()
    {
        //    $visits=Visit::select(['*'])->where('target_id',$this->id)->groupBy('who_id')->with('who')->orderBy('created_at','desc')->get();
        $visits = DB::table('visits')
                ->select('id','who_id')
                ->orderBy('created_at', 'desc')
                ->where('target_id', $this->id)
             //   ->groupBy('who_id')
                ->get();



        $collection = $visits->pluck('id')->toArray();


        $visits = Visit::select(['*'])->whereIN('id', $collection)->with('who')->has('who')->get();

        return $visits;
    }
/*
    public function scopeOrderByLastLogin($query, $direction = 'desc')
    {
        $query->orderBy(User::select('created_at')
                                ->whereColumn('logins.user_id', 'users.id')
                                ->latest()
                                ->take(1),
                        $direction
        );
    }
*/
    /**
     * Позволяет выбирать товары категории и всех ее потомков
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $parents
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function boot()
    {
        parent::boot();

        // Order by name ASC
     /*   static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
     */
    }
}
