<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("work_id")->nullable();
            $table->unsignedBigInteger("work_image_id")->nullable();
            $table->unsignedBigInteger("product_id")->nullable();
            $table->unsignedBigInteger("product_secondary_image_id")->nullable();
            $table->unsignedBigInteger("blog_id")->nullable();
            $table->timestamps();

            $table->foreign("work_id")->references("id")->on("works");
            $table->foreign("work_image_id")->references("id")->on("work_images");
            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("product_secondary_image_id")->references("id")->on("product_secondary_images");
            $table->foreign("blog_id")->references("id")->on("blogs");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_orders');
    }
}
