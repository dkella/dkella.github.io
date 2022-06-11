<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedOtConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('otConfig')->insert(
            array(
                array(
                    'typeOT' => 'A',
                    'description' => 'HARI KERJA BIASA',
                    'rate' => 1.125,
                ),
                array(
                    'typeOT' => 'B',
                    'description' => 'HARI CUTI MINGGU/HARI BIASA (MALAM)',
                    'rate' => 1.25,
                ),
                array(
                    'typeOT' => 'C',
                    'description' => 'HARI CUTI MINGGU (MALAM)',
                    'rate' => 1.5,
                ),
                array(
                    'typeOT' => 'D',
                    'description' => 'HARI KELEPASAN',
                    'rate' => 1.75,
                ),
                array(
                    'typeOT' => 'E',
                    'description' => 'HARI KELEPASAN (MALAM)',
                    'rate' => 2.00,
                ),

            )
        );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB:table('otConfig')->delete();
	}

}
