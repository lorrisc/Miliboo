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
        Schema::create('photo_produits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compte_client_id')->nullable()->constrained();
            $table->foreignId('produit_id')->nullable()->constrained();
            $table->foreignId('couleur_id')->nullable()->constrained();
            $table->foreignId('avis_id')->nullable()->constrained();
            $table->string('url_photo_produit');           

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
        Schema::dropIfExists('photo_produits');
    }
};
