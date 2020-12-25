<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum("status", ["aprobado", "rechazado"]);
            $table->double("total", 14, 2);
            $table->string("order_id");
            $table->unsignedBigInteger("guest_user_id");
            $table->string("tracking")->nullable();
            $table->text("address");
            $table->string("status_shipping")->nullable();
            $table->timestamps();

            $table->foreign("guest_user_id")->references("id")->on("guest_users");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
