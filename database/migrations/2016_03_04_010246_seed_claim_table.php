<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('claims')->insert(
            array(
                array(
                    'type' => 1,    //1-overtime 2-travel
                    'status' => 1,  //1- draft 2-submitted 3-approved 4-rejected
                    'month' => 1,   //January
                    'year' => 2016,
                    'total' => 115.94,
                    'user_id' => 2,  //staff
                ),
                array(
                    'type' => 2,    //1-overtime 2-travel
                    'status' => 1,  //1- draft 2-submitted 3-approved 4-rejected
                    'month' => 1,   //January
                    'year' => 2016,
                    'total' => 30.60,
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
        DB:table('claims')->delete();
	}

}
