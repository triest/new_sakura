<?php

    namespace App\Models;

    use App\Models\Lk\User;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class GiftAct extends Model
    {
        //
        protected $table = "gift_act";

        public $appends=['created'];
        /**
         * @var mixed|null
         */
        private $text;

        public function who()
        {
            return $this->hasOne(User::class, 'id', 'who_id');
        }

        public function target()
        {
            return $this->hasOne(User::class, 'id', 'target_id');
        }

        public function gift()
        {
            return $this->hasOne(Present::class,'id','present_id');
        }

        public function getCreatedAttribute()
        {
            $last_login = $this->created_at;
            if ($this->created_at == null) {
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
            }
            elseif($datediff->y == 0 && $datediff->m>1 && $datediff->m<5){
                $last_login = $datediff->m . " месяца назад";
            } elseif ($datediff->y == 0 && $datediff->m>=5) {
                $last_login = $datediff->m . " месяцев назад";
            } elseif ($datediff->y >= 1) {
                $last_login = "давно";
            }

            return $last_login;
        }
    }
