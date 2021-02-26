<?php

    namespace App\Models;

    use App\Models\Lk\User;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model
    {
        //
        protected $table = "messages";

        protected $fillable = ['from', 'to'];

        protected $appends = ['date'];

        public function fromContact()
        {
            return $this->hasOne(User::class, 'id', 'from');
        }

        public function toContact()
        {
            return $this->hasOne(User::class, 'id', 'to');
        }

        public function getDateAttribute()
        {
            $mytime = Carbon::now();
            $date = $this->created_at->format('Y-m-d H:i:s');
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);

            $datediff = date_diff($date, $mytime);

            if ($datediff->y == 0 && $datediff->m == 0 && $datediff->i == 0 && $datediff->h == 0) {
                return "только что";
            } elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0 && $datediff->i > 0 && $datediff->i < 30 && $datediff->h == 0) {
                return $datediff->i . " минуты назад";
            } elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0 && $datediff->i > 0 && $datediff->h > 0) {
                return $this->created_at->format('H:i');
            } elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0) {
                return $this->created_at->format('H:i');
            } elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 1) {
                return "вчера " . $this->created_at->format('H:i');
            } else {
                return $this->created_at->format('Y-m-d H:i');
            }
        }
    }
