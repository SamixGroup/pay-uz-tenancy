<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSystemParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('payuz.db_prefix') . 'payment_system_params', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system');
            $table->string('label')->nullable();
            $table->string('name')->nullable();
            $table->text('value')->nullable();
            $table->integer('tenant_id')->nullable();
            $table->string('tenant_type')->nullable();
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
        Schema::dropIfExists('payment_system_params');
    }
}