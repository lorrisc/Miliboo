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
        DB::statement("CREATE VIEW commande_mois_view AS
        SELECT DISTINCT EXTRACT(MONTH FROM date_commande) AS mois, EXTRACT(YEAR FROM date_commande) AS année, SUM(prix*promo*qte) AS prix
        FROM pivot_ligne_paniers plp
        JOIN produits p ON p.id = plp.produit_id
        JOIN pivot_unifiers pu ON pu.produit_id = plp.produit_id AND pu.couleur_id = plp.couleur_id
        JOIN commandes c ON c.id = commande_id
        GROUP BY EXTRACT(MONTH FROM date_commande), EXTRACT(YEAR FROM date_commande)
        order by année DESC, mois DESC;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS commande_mois_view");
    }
};
