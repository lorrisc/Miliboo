<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_ligne_paniers', function (Blueprint $table) {
            $table->primary(['produit_id', 'commande_id', 'couleur_id']);
            
            $table->foreignId('produit_id')->constrained();
            $table->foreignId('commande_id')->constrained();
            $table->foreignId('couleur_id')->constrained();

            $table->integer('qte');
            
            $table->timestamps();
        });

        DB::statement('ALTER TABLE pivot_ligne_paniers ADD CONSTRAINT ckc_qte check (qte >= 0)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_ligne_paniers');
    }
};
