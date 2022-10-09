<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Facturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->date('fecha_fac');
            $table->bigInteger('num_fac');  
            $table->decimal('monto'); // Importante: debe ser decimal(17,2) 
            $table->bigInteger('hiden'); // Ojo. debe ser null por default
            $table->bigInteger('added');
            $table->bigInteger('proveedor_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
