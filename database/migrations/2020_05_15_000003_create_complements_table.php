<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->index();
            $table->unsignedBigInteger('complement_taxon_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('complement_of_id')->index();
            $table->string('description');
            $table->string('short_description');
            $table->text('details')->nullable();
            $table->string('order')->nullable();
            $table->boolean('is_available')->nullable();
            $table->boolean('include')->nullable();
            $table->boolean('unique')->nullable();
            $table->boolean('by_default')->nullable();
            $table->float('quantity_inventory')->nullable();
            $table->float('retail_price')->nullable();
            $table->float('margin')->nullable();
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
        Schema::dropIfExists('complements');
    }
}
