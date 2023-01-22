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
        Schema::create('adresse_livraisons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ville_id')->constrained();
            $table->foreignId('civilite_id')->constrained();
            $table->foreignId('compte_client_id')->constrained();
            $table->foreignId('pay_id')->constrained();
            $table->foreignId('code_postal_id')->constrained();
            $table->string('nom_adresse', 50);
            $table->string('nom', 30);
            $table->string('prenom', 20);
            $table->string('adresse_livraison', 100);
            $table->string('tel', 10)->nullable();
            $table->string('indicatif_tel', 4)->nullable();
            $table->string('tel_portable', 10);
            $table->string('indicatif_tel_portable', 4);

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
        Schema::dropIfExists('adresse_livraisons');
    }
};
