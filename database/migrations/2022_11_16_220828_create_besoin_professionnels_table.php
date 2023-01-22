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
        Schema::create('besoin_professionnels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activite_pro_id')->constrained();
            $table->foreignId('sujet_besoin_pro_id')->constrained();
            $table->string('nom_societe', 50);
            $table->string('num_tva', 50)->nullable();
            $table->string('nom_prenom', 100);
            $table->string('email', 50);
            $table->string('adresse_bsn_pro', 100);
            $table->string('code_postal', 20);
            $table->string('ville', 50);
            $table->string('pays', 50);
            $table->string('tel', 10);
            $table->text('message');

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
        Schema::dropIfExists('besoin_professionnels');
    }
};
