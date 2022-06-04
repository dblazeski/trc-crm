<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('database.default') != 'sqlite') {
            return;
        }

        $db_path = config('database.connections.sqlite.database');

        if (File::exists($db_path)) {
            return;
        }

        // Create the empty db file
        File::put($db_path, '');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
