<?php

    namespace App\Models;

    use Backpack\CRUD\app\Models\Traits\CrudTrait;
    use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
    use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\SluggableScopeHelpers;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Model;

    class Target extends Model
    {
        use CrudTrait;


        protected $fillable = [
                'name'];

        //
        protected $table = "targets";
    }
