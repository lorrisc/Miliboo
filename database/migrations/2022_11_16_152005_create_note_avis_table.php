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
        Schema::create('note_avis', function (Blueprint $table) {
            $table->id();

            $table->integer('note_avis')->default(4);

            $table->timestamps();
        });

        DB::statement('ALTER TABLE note_avis ADD CONSTRAINT ckc_note_avis check (note_avis between 0 and 4)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_avis');
    }
};
