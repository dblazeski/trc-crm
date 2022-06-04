<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('resource_type');
            $table->string('file')->nullable()->default(NULL);;
            $table->string('snippet_description')->nullable()->default(NULL);;
            $table->text('snippet_html')->nullable()->default(NULL);;
            $table->string('link')->nullable()->default(NULL);;
            $table->boolean('link_in_new_tab')->default(false);

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
        Schema::dropIfExists('resources');
    }
};
