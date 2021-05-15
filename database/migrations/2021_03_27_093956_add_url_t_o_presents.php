<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlTOPresents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('presents', function (Blueprint $table) {
            $table->string('image_url',255)->after('enabled')->nullable()->default(null);
        //    $table->string('image',255)->after('enabled')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('presents', function (Blueprint $table) {
            $table->dropColumn('image_url');
      //      $table->dropColumn('image');
        });
    }
}
