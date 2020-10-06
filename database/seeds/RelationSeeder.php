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
        DB::table('relation')->insert([
                'name' => 'Нет',

        ]);
        DB::table('relation')->insert([
                'name' => 'Есть',

        ]);
        DB::table('relation')->insert([
                'name' => 'Все сложно',

        ]);
    }
}
