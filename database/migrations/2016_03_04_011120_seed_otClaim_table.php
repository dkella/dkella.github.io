<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedOtClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('otClaim')->insert(
            array(
                array(
                    'date' => \Carbon\Carbon::createFromDate(2016,01,01)->toDateTimeString(),
//                    'date' => '2016-01-01',
                    'startTime' => '8:00',
                    'endTime' => '12:00',
                    'totalHour' => 4,
                    'hourA' => 0,
                    'hourB' => 2,
                    'hourC' => 1,
                    'hourD' => 1,
                    'hourE' => 0,
                    'otDesc' => 'OPERASI BERSEPADU BERSAMA AGENSI ANTI DADAH KEBANGSAAN (ADDK) & POLIS DIRAJA MALAYSIA (PDRM)',
                    'totalClaim' => 56.74,
                    'isHoliday' => 1,
                    'claim_id' => 1,  //first default claim
                ),
                array(
                    'date' => \Carbon\Carbon::createFromDate(2016,01,02)->toDateTimeString(),
                    'startTime' => '15:00',
                    'endTime' => '19:00',
                    'totalHour' => 4,
                    'hourA' => 0,
                    'hourB' => 1,
                    'hourC' => 2,
                    'hourD' => 1,
                    'hourE' => 0,
                    'otDesc' => 'OPERASI BERSEPADU BERSAMA AGENSI ANTI DADAH KEBANGSAAN (ADDK) & POLIS DIRAJA MALAYSIA (PDRM)',
                    'totalClaim' => 59.20,
                    'isHoliday' => 0,
                    'claim_id' => 1,  //first default claim
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
        DB:table('otClaim')->delete();
	}

}
