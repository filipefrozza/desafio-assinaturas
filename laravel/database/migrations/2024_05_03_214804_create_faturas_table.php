<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('assinatura_id');
            $table->string('descricao');
            $table->date('data_vencimento');
            $table->boolean('pago')->default(false);
            $table->boolean('cancelado')->default(false);
            $table->date('data_pagamento')->nullable();
            $table->string('codigo_barra');
            $table->double('valor');
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
        Schema::dropIfExists('faturas');
    }
}
