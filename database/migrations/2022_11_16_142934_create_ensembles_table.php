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
        Schema::create('ensembles', function (Blueprint $table) {
            $table->id();

            $table->string('lib_ensemble', 150);
            $table->double('prix_ensemble');
            $table->double('promo_ensemble')->nullable();

            $table->timestamps();
        });

        DB::statement('ALTER TABLE ensembles ADD CONSTRAINT ckc_promo_ensemble check (promo_ensemble is not null or (promo_ensemble between 0 and 1))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ensembles');
    }
};
