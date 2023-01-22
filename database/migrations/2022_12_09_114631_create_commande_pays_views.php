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
        DB::statement("CREATE VIEW commande_pays_views AS SELECT DISTINCT pa.lib_pays, SUM(prix*promo*qte) AS prix
        FROM pivot_ligne_paniers plp
        JOIN produits p ON p.id = plp.produit_id
        JOIN pivot_unifiers pu ON pu.produit_id = plp.produit_id AND pu.couleur_id = plp.couleur_id
        JOIN pivot_dernieres_consults dc ON dc.produit_id = p.id
        JOIN compte_clients cl ON dc.compte_client_id = cl.id 
        JOIN pays pa ON pa.id = cl.pay_id
        JOIN commandes c ON c.id = commande_id
        GROUP BY pa.lib_pays
        ORDER BY pa.lib_pays;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS commande_pays_views");
    }
};
