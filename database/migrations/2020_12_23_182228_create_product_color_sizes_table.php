<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductColorSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_color_sizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("color_id");
            $table->unsignedBigInteger("size_id");
            $table->double("price");
            $table->text("description");
            $table->string("slug");
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onUpdate('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onUpdate('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_color_sizes');
    }
}
