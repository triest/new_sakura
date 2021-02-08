<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResizedAvatarUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table(
                'users',
                function (Blueprint $table) {
                    //

                    $table->string('small_photo_profile_url', 255)->nullable()->default(null);
                }
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
        Schema::table(
                'users',
                function (Blueprint $table) {
                    //
                    $table->dropColumn('small_photo_profile_url');
                }
        );
    }
}
