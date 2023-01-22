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
        DB::statement("CREATE VIEW commande_produits_view AS
        SELECT DISTINCT cat.lib_categorie, SUM(prix*promo*qte) AS prix, c.date_commande
        FROM pivot_ligne_paniers plp
        JOIN produits p ON p.id = plp.produit_id
        JOIN pivot_unifiers pu ON pu.produit_id = plp.produit_id AND pu.couleur_id = plp.couleur_id
        JOIN categories cat ON cat.id = p.categorie_i   d
        JOIN commandes c ON c.id = commande_id
        GROUP BY cat.lib_categorie, c.date_commande;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS commande_produits_view");
    }
};
