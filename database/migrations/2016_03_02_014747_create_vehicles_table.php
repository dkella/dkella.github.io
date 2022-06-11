<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vehicles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('plateNo')->unique();
            $table->string('vehicleName');
            $table->integer('engine')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('class_id')
            ->references('id')
            ->on('travelConfig');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vehicles');
	}

}
