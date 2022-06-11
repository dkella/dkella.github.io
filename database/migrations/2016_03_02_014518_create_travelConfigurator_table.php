<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelConfiguratorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('travelConfig', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('vehicleClass');
			$table->text('description');
			$table->integer('rateA')->unsigned();
			$table->integer('rateB')->unsigned();
			$table->integer('rateC')->unsigned();
			$table->integer('rateD')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('travelConfig');
	}

}
