<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuedanFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quedanfacturas', function (Blueprint $table) {
            
            $table->engine="InnoDB";
            
            $table->bigIncrements('id');
            $table->bigInteger('factura_id')->unsigned();
            $table->bigInteger('quedan_id')->unsigned();
            $table->bigInteger('hiden'); // Ojo. debe ser null por default
        
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->foreign('quedan_id')->references('id')->on('quedans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quedanfacturas');
    }
}
