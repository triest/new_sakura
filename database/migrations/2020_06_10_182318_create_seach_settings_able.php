<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateSeachSettingsAble extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('seach_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->nullable()->unsigned()->index();
                $table->string('target_array')->nullable()->index();
                $table->string('interest_array')->nullable()->index();
                $table->string('meet')->nullable();
                $table->integer('age_from')->nullable()->unsigned();
                $table->integer('age_to')->nullable()->unsigned();
                $table->integer('children')->unsigned()->nullable();
                $table->string('cookie', 1000)->nullable()->default(null);
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
            Schema::dropIfExists('seach_settings');
        }
    }
