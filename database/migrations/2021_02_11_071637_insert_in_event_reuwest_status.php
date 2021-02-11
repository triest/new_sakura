<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertInEventReuwestStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('event_request_status')->insert(
                array(
                        'id' => '1',
                        'name'=>'Не прочитанное'
                )
        );

        DB::table('event_request_status')->insert(
                array(
                        'id' => '2',
                        'name'=>'Принятый'
                )
        );

        DB::table('event_request_status')->insert(
                array(
                        'id' => '3',
                        'name'=>'Отклоненый'
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
        Schema::table('event_request_status', function (Blueprint $table) {
            //
        });
    }
}
