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
        //
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
        });
        
        // For the Sales table migration
        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
        });
        
        // For the Inventories table migration
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
