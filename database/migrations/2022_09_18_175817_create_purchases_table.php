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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_no');
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('supplier');
            // transaction type return / purchase reduandand no use
            $table->unsignedBigInteger('type');
            // transaction type return / purchase
            $table->unsignedBigInteger('tran_type');
            $table->double('total');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('purchase_date');
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
        Schema::dropIfExists('purchases');
    }
};
