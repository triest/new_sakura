<?php

    namespace App;

    use App\Models\Lk\User;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model
    {
        //
        protected $table = "messages";

        public function fromContact()
        {
            return $this->hasOne(User::class, 'id', 'from');
        }

        public function toContact()
        {
            return $this->hasOne(User::class, 'id', 'to');
        }
    }
