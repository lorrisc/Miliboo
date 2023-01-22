<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public $nomProcedure = 'anonymise';


    /**

    * Run the migrations.

    *

    * @return void

    */

    public function up()

    {

        $procedure = "

            CREATE PROCEDURE $this->nomProcedure(...)
            MODIFIES SQL DATA
            BEGIN
                -- ...
                -- Programmé par : ...
                -- Le : ...
                -- Historique des modifications
                -- Par :
                -- Le :
                -- Modifications :
                ...
            END
        ";

        DB::unprepared("DROP procedure IF EXISTS $this->nomProcedure");
        DB::unprepared($procedure);

    }

 

    /**

    * Reverse the migrations.

    *

    * @return void

    */

    public function down()

    {

        DB::unprepared("DROP PROCEDURE IF EXISTS $this->nomProcedure");

    }
};
