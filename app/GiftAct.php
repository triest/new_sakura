<?php

    namespace App;

    use App\Models\Lk\User;
    use Illuminate\Database\Eloquent\Model;

    class GiftAct extends Model
    {
        //
        protected $table = "gift_act";

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
            return $this->hasOne('App\Present');
        }
    }
