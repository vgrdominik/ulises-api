<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->index();
            $table->unsignedBigInteger('channel_id')->index();
            $table->unsignedBigInteger('parent_taxon_id')->index();
            $table->string('description');
            $table->string('short_description');
            $table->string('details');
            $table->string('photo');
            $table->string('order');
            $table->boolean('is_available');
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
        Schema::dropIfExists('taxons');
    }
}