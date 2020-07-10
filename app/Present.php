<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Present extends Model
    {
        //
        protected $table = "presents";

        public static function getPresents()
        {
            return Present::select(['*'])->where('enabled', 1)->get();
        }

        public static function get($id)
        {
            return Present::select(['*'])->where('id', $id)->first();
        }
    }
