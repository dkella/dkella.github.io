<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('department');
			$table->timestamps();
		});

//        Schema::create('department_user', function(Blueprint $table)
//        {
//            $table->integer('user_id')->unsigned()->index();
//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');
//
//            $table->integer('dept_id')->unsigned()->index();
//            $table->foreign('dept_id')
//                ->references('id')
//                ->on('departments')
//                ->onDelete('cascade');
//
//            $table->timestamps();
//        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('departments');
//        Schema::drop('department_user');
	}

}
