<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreatePresentsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('presents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 191)->nullable();
                $table->integer('price')->nullable();
                $table->string('image', 255)->nullable();
                $table->boolean('enabled')->default(false)->nullable();
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
            Schema::dropIfExists('presents');
        }
    }
