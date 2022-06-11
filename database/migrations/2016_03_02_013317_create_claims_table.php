<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('claims', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('type')->unsigned();
			$table->integer('status')->unsigned();
			$table->integer('month')->unsigned();
			$table->integer('year')->unsigned();
			$table->double('total');
			$table->integer('user_id')->unsigned();
			$table->timestamps();
			$table->foreign('user_id')
					->references('id')
					->on('users')
					->onDelete('cascade');
		});

//        Schema::create('claim_user', function(Blueprint $table)
//        {
//            $table->integer('user_id')->unsigned()->index();
//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');
//
//            $table->integer('claim_id')->unsigned()->index();
//            $table->foreign('claim_id')
//                ->references('id')
//                ->on('claims')
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
		Schema::drop('claims');
//		Schema::drop('claim_user');
	}

}