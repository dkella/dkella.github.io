<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('noKP',12)->unique();
			$table->string('position');
			// $table->integer('role_id')->unsigned(); //unsigned..integer must be positive
			$table->integer('dept_id')->unsigned(); //unsigned..integer must be positive
			$table->string('branch');
			$table->text('homeAddress');
			$table->string('salary');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamps();

//            $table->foreign('role_id')
//                ->references('id')
//                ->on('roles');

            $table->foreign('dept_id')
                ->references('id')
                ->on('departments');
		});

        Schema::create('supervision', function(Blueprint $table)
        {
            $table->integer('staff_id')->unsigned()->index();
            $table->foreign('staff_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('sv_id')->unsigned()->index();
            $table->foreign('sv_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

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
		Schema::drop('users');
		Schema::drop('supervision');
	}

}