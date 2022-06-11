<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTravelClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('travelClaim')->insert(
            array(
                array(
                    'date' => \Carbon\Carbon::createFromDate(2016,01,13)->toDateTimeString(),
//                    'date' => '2016-01-13',
                    'startTime' => '8:00',
                    'endTime' => '12:00',
                    'hour' => 4,
                    'task_id' => 1,
                    'travelDesc' => 'Dari pejabat Penguatkuasaan Munsyi Ibrahim ke
                                    B) Taman Maju Jaya, C) Taman Sentosa dan A) Taman Pelangi.
                                    Pulang ke pejabat Penguatkuasaan Munsyi Ibrahim.
                                    (SEPERTI JADUAL RONDAAN BERKALA BULAN DISEMBER 2013)',
                    'mileage' => 34,
//                    'totalClaim' => 56.74,
                    'claim_id' => 2,  //2nd default claim
                ),
                array(
                    'date' => \Carbon\Carbon::createFromDate(2016,01,11)->toDateTimeString(),
                    'startTime' => '15:00',
                    'endTime' => '19:00',
                    'hour' => 4,
                    'task_id' => 1,
                    'travelDesc' => 'Dari pejabat Penguatkuasaan Munsyi Ibrahim ke
                                    B) Taman Maju Jaya, C) Taman Sentosa dan A) Taman Pelangi.
                                    Pulang ke pejabat Penguatkuasaan Munsyi Ibrahim.
                                    (SEPERTI JADUAL RONDAAN BERKALA BULAN DISEMBER 2013)',
                    'mileage' => 34,
                    'claim_id' => 2,  //2nd default claim
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
        DB:table('travelClaim')->delete();
	}

}
