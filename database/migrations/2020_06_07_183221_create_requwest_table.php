<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateRequwestTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('requwest', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 191)->nullable();
                $table->integer('who_id')->unsigned()->index();
                $table->integer('target_id')->unsigned()->index();
                $table->string('status')->nullable()->default("not_read");
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
            Schema::dropIfExists('requwest');
        }
    }
