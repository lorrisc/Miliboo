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
        Schema::create('compte_clients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ville_id')->constrained();
            $table->foreignId('civilite_id')->constrained();
            $table->foreignId('code_postal_id')->constrained();
            $table->foreignId('pay_id')->constrained();

            $table->string('email', 100);
            $table->string('password', 50);
            $table->string('nom', 30);
            $table->string('prenom', 20);
            $table->string('adresse_client', 100);
            $table->string('tel', 10)->nullable();
            $table->string('indicatif_tel', 4)->nullable();
            $table->string('tel_portable', 10);
            $table->string('indicatif_tel_portable', 4);
            $table->boolean('newsletter_miliboo')->default(0);
            $table->boolean('newsletter_partenaire')->default(0);
            $table->integer('point_fidelite')->nullable();
            $table->string('num_carte', 16)->nullable();
            $table->date('date_exp')->nullable();
            $table->string('cryptogramme', 3)->nullable();
            $table->boolean('client_pro')->default(0);

            $table->timestamps();
        });

        DB::statement('ALTER TABLE compte_clients ADD CONSTRAINT ckc_point_fidelite_compteclient check (point_fidelite is not null or (point_fidelite >= 0))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compte_clients');
    }
};
