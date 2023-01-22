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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produit_id')->nullable()->constrained();
            $table->foreignId('categorie_id')->constrained();
            
            $table->string('lib_produit', 200);
            $table->string('commentaire_entretien', 200)->nullable();
            $table->integer('qte_produit');
            
            $table->double('d_tot_longueur')->nullable();
            $table->double('d_tot_profondeur')->nullable();
            $table->double('d_tot_hauteur')->nullable();

            $table->double('d_dos_longueur')->nullable();
            $table->double('d_dos_profondeur')->nullable();
            $table->double('d_dos_hauteur')->nullable();

            $table->double('d_ass_longueur')->nullable();
            $table->double('d_ass_profondeur')->nullable();
            $table->double('d_ass_hauteur')->nullable();

            $table->double('hauteur_pieds')->nullable();

            $table->string('revetement', 150)->nullable();
            $table->string('matiere', 150)->nullable();
            $table->string('matiere_pieds', 150)->nullable();

            $table->string('type_mousse_assise', 150)->nullable();
            $table->string('type_mousse_dossier', 150)->nullable();

            $table->double('densite_assise')->nullable();
            $table->double('densite_dossier')->nullable();

            $table->double('d_longueur_colis')->nullable();
            $table->double('d_profondeur_colis')->nullable();
            $table->double('d_hauteur_colis')->nullable();

            $table->double('poids_max')->nullable();
            $table->double('d_poids_colis')->nullable();

            $table->double('epaisseur_assise')->nullable();

            $table->double('d_deplie_longueur')->nullable();
            $table->double('d_deplie_largeur')->nullable();
            $table->double('d_deplie_profondeur')->nullable();

            $table->double('longueur_accoudoir')->nullable();
            $table->double('profondeur_accoudoir')->nullable();
            $table->double('hauteur_accoudoir')->nullable();

            $table->timestamps();
        });

        DB::statement('ALTER TABLE produits ADD constraint ckc_dtotlongueur_produits check (d_tot_longueur is not null or (d_tot_longueur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dtotprofondeur_produits check (d_tot_profondeur is not null or (d_tot_profondeur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dtothauteur_produits check (d_tot_hauteur is not null or (d_tot_hauteur >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_ddoslongeur_produits check (d_dos_longueur is not null or (d_dos_longueur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_ddosprofondeur_produits check (d_dos_profondeur is not null or (d_dos_profondeur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_ddoshauteur_produits check (d_dos_hauteur is not null or (d_dos_hauteur >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_dasslongeur_produits check (d_ass_longueur is not null or (d_ass_longueur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dassprofondeur_produits check (d_ass_profondeur is not null or (d_ass_profondeur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dasshauteur_produits check (d_ass_hauteur is not null or (d_ass_hauteur >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_hauteurpieds_produits check (hauteur_pieds is not null or (hauteur_pieds >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_densiteassise_produits check (densite_assise is not null or (densite_assise >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_densitedossier_produits check (densite_dossier is not null or (densite_dossier >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_dlongcolis_produits check (d_longueur_colis is not null or (d_longueur_colis >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dprofcolis_produits check (d_profondeur_colis is not null or (d_profondeur_colis >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dhautcolis_produits check (d_hauteur_colis is not null or (d_hauteur_colis >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_poidsmax_produits check (poids_max is not null or (poids_max >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_dpoidscolis_produits check (d_poids_colis is not null or (d_poids_colis >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_epaisseur_de_assise_produits check (epaisseur_assise is not null or (epaisseur_assise >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_ddeplielongueur_produits check (d_deplie_longueur is not null or (d_deplie_longueur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_ddeplielargeur_produits check (d_deplie_largeur is not null or (d_deplie_largeur >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_ddeplieprofondeur_produits check (d_deplie_profondeur is not null or (d_deplie_profondeur >= 0))');

        DB::statement('ALTER TABLE produits ADD constraint ckc_longueuraccoudoir_produits check (longueur_accoudoir is not null or (longueur_accoudoir >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_profondeuraccoudoir_produits check (profondeur_accoudoir is not null or (profondeur_accoudoir >= 0))');
        DB::statement('ALTER TABLE produits ADD constraint ckc_hauteuraccoudoir_produits check (hauteur_accoudoir is not null or (hauteur_accoudoir >= 0))');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
};
