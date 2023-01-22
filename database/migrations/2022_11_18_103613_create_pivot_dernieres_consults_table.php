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
        Schema::create('pivot_dernieres_consults', function (Blueprint $table) {
            $table->primary(['produit_id','compte_client_id']);
            
            $table->foreignId('produit_id')->constrained();
            $table->foreignId('compte_client_id')->constrained();

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
        Schema::dropIfExists('pivot_dernieres_consults');
    }
};
