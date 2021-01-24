<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlurAvatar extends Migration
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
                    $table->string('blur_photo_profile_url', 255)->nullable()->default(null);
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
                    $table->dropColumn('blur_photo_profile_url');
                }
        );
    }
}
