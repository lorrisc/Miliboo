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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compte_client_id')->constrained();
            $table->foreignId('paiement_id')->constrained();
            $table->foreignId('livreur_id')->constrained();
            $table->text('instruction')->nullable();
            $table->boolean('livraison_express')->nullable()->default(0);
            $table->string('statut_commande', 50, [])->nullable();
            $table->dateTime('date_commande')->nullable()->useCurrent();

            $table->timestamps();
        });

        DB::statement('ALTER TABLE commandes ADD CONSTRAINT statut_commande CHECK (statut_commande is not null or (statut_commande in (\'validee\',\'refus\',\'refusnonvalide\',\'reserve\')))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
