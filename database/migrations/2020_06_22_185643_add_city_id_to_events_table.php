<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddCityIdToEventsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('events', function (Blueprint $table) {
                //
                $table->bigInteger('city_id')->nullable()->after("min_people")->default(null);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('events', function (Blueprint $table) {
                //
                $table->dropColumn('city_id');
            });
        }
    }
