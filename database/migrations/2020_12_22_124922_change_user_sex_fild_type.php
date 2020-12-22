<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserSexFildType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public
    function up()
    {
        //
        Schema::table(
                'users',
                function (Blueprint $table) {
                    //
                    $table->dropColumn('sex');
                }
        );

        Schema::table(
                'users',
                function (Blueprint $table) {
                    //
                    $table->enum('sex', ['male', 'female'])->nullable()->default(null);
                }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public
    function down()
    {
        Schema::table(
                'users',
                function (Blueprint $table) {
                    //
                    $table->dropColumn('sex');
                }
        );

        //
        Schema::table(
                'users',
                function (Blueprint $table) {
                    $table->string('sex', 30)->nullable()->default("");
                }
        );
    }
}
