<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddFieldsToUsersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                //
                $table->string('phone', 191)->nullable();
                $table->text('description')->nullable();
                $table->text('private')->nullable();
                $table->dateTime('biginvip')->nullable();
                $table->dateTime('endvip')->nullable();
                $table->string('sex', 10)->nullable();
                $table->integer('age')->nullable()->unsigned();
                $table->integer('weight')->nullable()->unsigned();
                $table->integer('height')->nullable()->unsigned();
                $table->string('meet', 10)->nullable();
                $table->boolean('banned')->default(false);
                $table->integer('country_id')->nullable()->unsigned()->index();
                $table->integer('region_id')->nullable()->unsigned()->index();
                $table->integer('city_id')->nullable()->unsigned()->index();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                //
                $table->dropColumn('phone', 191);
                $table->dropColumn('description');
                $table->dropColumn('private');
                $table->dropColumn('biginvip');
                $table->dropColumn('endvip');
                $table->dropColumn('sex', 10);
                $table->dropColumn('age');
                $table->dropColumn('weight');
                $table->dropColumn('height');
                $table->dropColumn('meet', 10);
                $table->dropColumn('banned');
                $table->dropColumn('country_id');
                $table->dropColumn('region_id');
                $table->dropColumn('city_id');
            });
        }
    }
