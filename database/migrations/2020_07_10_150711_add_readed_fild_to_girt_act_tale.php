<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReadedFildToGirtActTale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_act', function (Blueprint $table) {
            //
            $table->boolean('readed')->nullable()->default(false)->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('girt_act_tale', function (Blueprint $table) {
            //
            $table->dropColumn('readed');
        });
    }
}
