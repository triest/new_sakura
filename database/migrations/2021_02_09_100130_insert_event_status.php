<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertEventStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('event_status')->insert(
                array(
                        'id' => '1',
                        'name'=>'Черновик'
                )
        );

        DB::table('event_status')->insert(
                array(
                        'id' => '2',
                        'name'=>'Ожидает учстников'
                )
        );

        DB::table('event_status')->insert(
                array(
                        'id' => '3',
                        'name'=>'Ожидает начала'
                )
        );

        DB::table('event_status')->insert(
                array(
                        'id' => '4',
                        'name'=>'Идет'
                )
        );

        DB::table('event_status')->insert(
                array(
                        'id' => '5',
                        'name'=>'Состоялось'
                )
        );

        DB::table('event_status')->insert(
                array(
                        'id' => '6',
                        'name'=>'Отменено'
                )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
