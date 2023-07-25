<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('system');
            $table->integer('tenant_id')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('status')->default(\Makkapoya\PayUz\Models\PaymentSystem::NOT_ACTIVE);
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
        Schema::dropIfExists('payment_systems');
    }
}