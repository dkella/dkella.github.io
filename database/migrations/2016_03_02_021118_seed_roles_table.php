<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('roles')->insert(
            array(
                array('role' => 'admin'),
                array('role' => 'staff'),
                array('role' => 'supervisor'),
                array('role' => 'financial clerk'),
                array('role' => 'financial manager'),

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
		DB:table('roles')->delete();
	}

}
