<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->index();
            $table->unsignedBigInteger('vendor_id')->index();
            $table->string('description');
            $table->string('short_description');
            $table->string('barcode');
            $table->string('sku');
            $table->string('photo');
            $table->string('order');
            $table->boolean('send');
            $table->boolean('compulsory_complements');
            $table->boolean('is_available');
            $table->boolean('inventory');
            $table->float('quantity_inventory');
            $table->float('retail_price');
            $table->float('retail_price2');
            $table->float('retail_price3');
            $table->float('retail_price4');
            $table->float('iva');
            $table->float('handling_fee');
            $table->float('product_cost');
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
        Schema::dropIfExists('products');
    }
}
