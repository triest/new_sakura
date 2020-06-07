<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateAlbumsPhotoTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('albums_photo', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('album_id')->nullable()->default(null);
                $table->string('name')->nullable()->default(null);
                $table->string('description')->nullable()->default(null);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('albums_photo');
        }
    }
