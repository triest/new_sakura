<?php

    namespace App\Models\Lk;

    use App\Notifications\ResetPassword;
    use App\Notifications\VerifyEmail;
    use Carbon\Carbon;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    /**
     * App\Models\Lk\User
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property string $phone
     * @property \Illuminate\Support\Carbon|null $email_verified_at
     * @property string $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User wherePhone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereUpdatedAt($value)
     * @mixin \Eloquent
     * @method static bool|null forceDelete()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\Lk\User onlyTrashed()
     * @method static bool|null restore()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereDeletedAt($value)
     * @method static \Illuminate\Database\Query\Builder|\App\Models\Lk\User withTrashed()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\Lk\User withoutTrashed()
     * @property string $surname
     * @property int $active
     * @property string|null $last_active
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereLastActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereSurname($value)
     * @property-read string $full_name
     * @property string|null $carousel_uid
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User whereCarouselUid($value)
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lk\Children[] $childrens
     * @property-read int|null $childrens_count
     * @property-read \Illuminate\Database\Eloquent\Collection $groups
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lk\Purchase[] $purchases
     * @property-read int|null $purchases_count
     * @property string $photo
     * @property-read \Illuminate\Database\Eloquent\Collection $children_groups
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lk\User wherePhoto($value)
     */
    class User extends Authenticatable implements MustVerifyEmail
    {
        use Notifiable;
        use SoftDeletes;

        protected $table = 'users';


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
                'date_birth'
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
                'password',
                'remember_token',
        ];

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
            return $this->belongsToMany('App\Target', 'user_target', 'user_id',
                    'target_id');
        }

        public function interest()
        {
            return $this->belongsToMany('App\Interest', 'user_interest', 'user_id',
                    'interest_id');
        }


        public function getAge()
        {
            $dateBith = $this->date_birth;

            $mytime = Carbon::now();
            $last_login = Carbon::createFromFormat('Y-m-d', $dateBith);
            $datediff = date_diff($last_login, $mytime);
            return $datediff->y;
        }

        public static function get($id)
        {
            return User::select(['*'])->where('id', $id)->first();
        }

        public function albums()
        {
            return $this->hasMany('App\Album');
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
                        if (filter_var($ip, FILTER_VALIDATE_IP,
                                        FILTER_FLAG_NO_PRIV_RANGE
                                        | FILTER_FLAG_NO_RES_RANGE) !== false
                        ) {
                            return $ip;
                        }
                    }
                }
            }

            return null;
        }

    }
