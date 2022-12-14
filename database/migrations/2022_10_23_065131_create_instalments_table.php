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
        
        Schema::create('instalments', function (Blueprint $table) {

            $table->id();
            $table->unsignedInteger('sale_id');
            $table->integer('instalment_no')->nullable();
            $table->double('amount');
            $table->double('amount_paid')->nullable();
            $table->boolean('instalment_paid');
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('instalments');
    }
};
