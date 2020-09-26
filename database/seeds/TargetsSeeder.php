<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    class TargetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('targets')->insert([
                'name' => 'встречи',

        ]);
        DB::table('targets')->insert([
                'name' => 'свидания',

        ]);
        DB::table('targets')->insert([
                'name' => 'отношения',

        ]);
        DB::table('targets')->insert([
                'name' => 'создание семьи',
        ]);
    }
}
