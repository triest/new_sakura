<?php

    namespace App\Models;

    use App\Models\Lk\User;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model
    {
        //
        protected $table = "messages";

        protected $fillable = ['from', 'to'];

        public function fromContact()
        {
            return $this->hasOne(User::class, 'id', 'from');
        }

        public function toContact()
        {
            return $this->hasOne(User::class, 'id', 'to');
        }
    }
