<?php

namespace App\Models;

use App\Models\Lk\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    protected $appends = ['date'];
    //
    public function who()
    {
        return $this->belongsTo(User::class,'who_id','id');
    }

    public function target()
    {
        return $this->belongsTo(User::class,'target_id','id');
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
            if($datediff->i==1){
                return "минуту назад";
            }elseif ($datediff->i>=5 && $datediff->i<=9){
                return "минут назад";
            }else {
                return $datediff->i . " минуты назад";
            }
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
