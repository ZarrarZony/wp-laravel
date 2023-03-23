<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SitesPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites_pages', function (Blueprint $table) {
            $table->increments('page_id');
            $table->integer('site_id');
            $table->string('title',100);
            $table->string('template',200);
            $table->string('content');
            $table->rememberToken();
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
        Schema::table('sites_pages', function (Blueprint $table) {
            //
        });
    }
}
