<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('interest')->insert([
                'name' => 'кино',

        ]);
        DB::table('interest')->insert([
                'name' => 'книги',

        ]);
        DB::table('interest')->insert([
                'name' => 'походы',

        ]);
    }
}
