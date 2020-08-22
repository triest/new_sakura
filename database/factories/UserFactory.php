<?php

    /** @var \Illuminate\Database\Eloquent\Factory $factory */

    use App\Models\Lk\User;
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

    $factory->define(User::class, function (Faker $faker) {

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


        return [
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
                'city_id' => 2,
                'date_birth' => $faker->dateTime('-18 years'),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
        ];
    });
