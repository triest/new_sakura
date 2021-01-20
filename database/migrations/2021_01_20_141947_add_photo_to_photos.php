<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
                'albums_photo',
                function (Blueprint $table) {
                    //
                    $table->string('short_patch', 255)->nullable()->default(null);
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
        Schema::table(
                'albums_photo',
                function (Blueprint $table) {
                    //
                    $table->dropColumn('short_patch');
                }
        );
    }
}
