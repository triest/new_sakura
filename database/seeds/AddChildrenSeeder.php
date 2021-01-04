<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddChildrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('children')->insert(
                [       'id'=>3,
                        'name' => 'не важно',
                ]
        );
        DB::table('children')->insert(
                [       'id'=>1,
                        'name' => 'есть',
                ]
        );
        DB::table('children')->insert(
                [       'id'=>2,
                        'name' => 'нет',
                ]
        );
    }
}
