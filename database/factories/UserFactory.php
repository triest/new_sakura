<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lk\User;
use App\Models\Relation;
use App\Models\Target;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
        User::class,
        function (Faker $faker) {
            if (random_int(0, 1)) {
                $sex = "female";
                $name = $faker->firstNameFemale;
            } else {
                $sex = "male";
                $name = $faker->firstNameMale;
            }

            if ($sex == "female") {
                $meet = "male";
            } else {
                $meet = "female";
            }
            $relation = null;
            $count = 0;
            while ($relation == null) {
                $count = $count + 1;
                if ($count > 10) {
                    break;
                }
                $relation = Relation::inRandomOrder()->first();
            }
            $date= $faker->date('Y-m-d','-18 years');

            $user = User::create(
                    [
                            'name' => $name,
                            'email' => $faker->unique()->safeEmail,
                            'email_verified_at' => now(),
                            'phone' => $faker->phoneNumber,
                            'description' => $faker->realText(),
                            'private' => $faker->realText(),
                            'sex' => $sex,
                            'weight' => $faker->numberBetween(50, 90),
                            'height' => $faker->numberBetween(150, 190),
                            'meet' => $meet,
                            'city_id' => 1,
                            'date_birth' => $date,
                            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                            'remember_token' => Str::random(10),
                            'relation_id' => $relation->id
                    ]
            );

            // теперь случайно выбираем цели

            $count_target = \App\Models\Target::select(['*'])->count();
            $num_target = rand(1, $count_target);

            $targets = Target::inRandomOrder()->limit($num_target)->get();

            foreach ($targets as $target) {
                $user->target()->save($target);
            }

            $count_target = \App\Models\Interest::select(['*'])->count();
            $num_target = rand(1, $count_target);

            $targets = \App\Models\Interest::inRandomOrder()->limit($num_target)->get();

            foreach ($targets as $target) {
                $user->interest()->save($target);
            }


            return $user->toArray();
        }
);
