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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compte_client_id')->constrained();
            $table->foreignId('reponse_societe_id')->nullable()->constrained();
            $table->foreignId('produit_id')->constrained();
            $table->foreignId('note_avis_id')->constrained();
            $table->string('titre_avis', 100);
            $table->text('detail_avis');
            $table->dateTime('date_avis')->useCurrent();
            
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
        Schema::dropIfExists('avis');
    }
};
