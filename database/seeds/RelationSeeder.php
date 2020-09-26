<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class RelationSeeder extends Seeder
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
                'name' => 'Нет',

        ]);
        DB::table('interest')->insert([
                'name' => 'Есть',

        ]);
        DB::table('interest')->insert([
                'name' => 'Все сложно',

        ]);
    }
}
