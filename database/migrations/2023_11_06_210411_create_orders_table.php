<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');

            $table->string('source_mobile');
            $table->string('source_name')->collation('utf8_general_ci');
            $table->string('source_address')->collation('utf8_general_ci');
            $table->string('source_latitude');
            $table->string('source_longitude');

            $table->string('destination_mobile');
            $table->string('destination_name')->collation('utf8_general_ci');
            $table->string('destination_address')->collation('utf8_general_ci');
            $table->string('destination_latitude');
            $table->string('destination_longitude');

            $table->string('tracking_code');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
