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
            $table->text('details');
            $table->string('order');
            $table->boolean('is_available');
            $table->boolean('include');
            $table->boolean('unique');
            $table->boolean('by_default');
            $table->float('quantity_inventory');
            $table->float('retail_price');
            $table->float('margin');
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
