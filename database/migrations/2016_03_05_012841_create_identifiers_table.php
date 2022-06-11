<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifiersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('identifiers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('code'); //the identifier code
            $table->string('name');
            $table->string('type'); //identifier_type
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
		Schema::drop('identifiers');
	}

}
