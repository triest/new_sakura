<?php

    namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lk\User;

class Dialog extends Model
{
    //
    //
    protected $table = 'dialogs';

    protected $appends = ['date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'id',
            'my_id',
            'other_id',
            'created_at',
            'updated_at'
    ];

    public function owner(){
        return $this->hasOne(User::class,'id','my_id');
    }

    public function other(){
        return $this->hasOne(User::class,'id','other_id');
    }

    public function getDateAttribute(){
        $mytime = Carbon::now();
        $date=$this->lastMessage;

        if(!$date){
            return null;
        }

        $date=Carbon::createFromFormat('Y-m-d H:i:s', $date);

        $datediff = date_diff($date, $mytime);

        if ( $datediff->y == 0 && $datediff->m == 0 && $datediff->i == 0  && $datediff->h == 0 ){
            return "только что";
        }elseif ( $datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0  && $datediff->i > 0  && $datediff->i < 30 && $datediff->h == 0){
            return $datediff->i. " минуты назад";
        }elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0  && $datediff->i > 0  && $datediff->h > 0){
            return $this->created_at->format('H:i');
        }elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0){
            return $this->created_at->format('H:i');
        }else{
            return $this->created_at->format('Y-m-d H:i:s');
        }
    }
}
