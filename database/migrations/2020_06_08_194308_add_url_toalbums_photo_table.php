<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddUrlToalbumsPhotoTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            //
            Schema::table('albums_photo', function (Blueprint $table) {
                //
                $table->string('url')->nullable()->default(null);

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
            Schema::table('albums_photo', function (Blueprint $table) {
                //
                $table->dropColumn("albums_photo");
            });
        }
    }
