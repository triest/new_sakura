<?php

    namespace App\Models;

    use App\Models\Lk\User;
    use Illuminate\Database\Eloquent\Model;

    class GiftAct extends Model
    {
        //
        protected $table = "gift_act";
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
    }
