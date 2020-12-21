<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
                'seach_settings',
                function (Blueprint $table) {
                    //
                    //    $table->foreignId('relation_id')->references('id')->on('relation');
                    $table->integer('relation_id')->nullable()->default(null);
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
                'seach_settings',
                function (Blueprint $table) {
                    //
                    $table->dropColumn('relation_id');
                    //     $table->dropForeign('relation_id');
                }
        );
    }
}
