<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTravelConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('travelConfig')->insert(
            array(
                array(
                    'vehicleClass' => 'A',
                    'description' => '> 1.4cc',
                    'rateA' => 70,
                    'rateB' => 65,
                    'rateC' => 60,
                    'rateD' => 55,
                ),
                array(
                    'vehicleClass' => 'B',
                    'description' => '> 1.0cc',
                    'rateA' => 60,
                    'rateB' => 55,
                    'rateC' => 50,
                    'rateD' => 45,
                ),
                array(
                    'vehicleClass' => 'C',
                    'description' => '<= 1.0cc',
                    'rateA' => 50,
                    'rateB' => 45,
                    'rateC' => 40,
                    'rateD' => 35,
                ),
                array(
                    'vehicleClass' => 'D',
                    'description' => '> 175cc',
                    'rateA' => 45,
                    'rateB' => 40,
                    'rateC' => 35,
                    'rateD' => 30,
                ),
                array(
                    'vehicleClass' => 'E',
                    'description' => '< 175cc',
                    'rateA' => 40,
                    'rateB' => 35,
                    'rateC' => 30,
                    'rateD' => 25,
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
        DB:table('travelConfig')->delete();
	}

}
