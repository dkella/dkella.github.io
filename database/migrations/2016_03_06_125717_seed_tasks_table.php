<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('tasks')->insert(
            array(
                array('task_name' => 'Kebersihan & Halangan'),
                array('task_name' => 'Iklan Premis/ Luar Premis'),
                array('task_name' => 'Perlesenan/ Penjaja'),
                array('task_name' => 'Vandalisme'),
                array('task_name' => 'Naziran (Bancian)'),
                array('task_name' => 'Struktur Binaan'),
                array('task_name' => 'Tugasan Lain'),

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
        DB:table('tasks')->delete();
	}

}
