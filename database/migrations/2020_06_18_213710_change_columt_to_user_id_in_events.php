<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class ChangeColumtToUserIdInEvents extends Migration
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
                $table->renameColumn('organizer_id', 'user_id');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('user_id_in_events', function (Blueprint $table) {
                //
                $table->renameColumn('user_id', 'organizer_id');
            });
        }
    }
