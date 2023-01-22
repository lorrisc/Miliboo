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
        Schema::create('pivot_unifiers', function (Blueprint $table) {
            $table->primary(['couleur_id','produit_id']);
            
            $table->foreignId('couleur_id')->constrained();
            $table->foreignId('produit_id')->constrained();
            $table->foreignId('ensemble_id')->constrained();

            $table->double('prix');
            $table->double('promo');
            $table->string('text_descr')->nullable();

            $table->timestamps();
        });

        DB::statement('ALTER TABLE pivot_unifiers ADD CONSTRAINT ckc_prix_sup_zero check (prix > 0)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_unifiers');
    }
};
