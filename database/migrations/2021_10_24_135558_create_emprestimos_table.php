<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprestimosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->double('valor',10,2);
            $table->double('valor_total',10,2);
            $table->enum('status',['0','1', '2']);
            $table->integer('parcelas');
            $table->unsignedBigInteger('corretor_id');
            $table->double("comissao_corretor")->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')
            ->references('id')
            ->on('users');

            $table->foreign('corretor_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emprestimos');
    }
}
