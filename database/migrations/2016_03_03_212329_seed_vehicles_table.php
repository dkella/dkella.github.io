<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedVehiclesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('vehicles')->insert(
            array(
                array(
                        'plateNo' => 'JFH 1681',
                        'vehicleName' => 'Perodua Kancil',
                        'engine' => 660,   //660cc
                        'class_id' => 4,  //class D
                        'user_id' => 2,  //staff
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
        DB:table('vehicles')->delete();
	}

}
