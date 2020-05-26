<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->index();
            $table->string('description');
            $table->string('short_description');
            $table->text('details');
            $table->string('nif');
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->string('province');
            $table->string('mobile');
            $table->string('email');
            $table->string('password');
            $table->string('default_rate');
            $table->string('type');
            $table->string('token');
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
        Schema::dropIfExists('vendors');
    }
}
