<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('otClaim', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamp('date')->useCurrent();
			$table->time('startTime');
			$table->time('endTime');
			$table->double('totalHour');
			$table->double('hourA');
			$table->double('hourB');
			$table->double('hourC');
			$table->double('hourD');
			$table->double('hourE');
			$table->text('otDesc');
			$table->double('totalClaim');
			$table->integer('isHoliday')->unsigned();
			$table->integer('flag')->nullable();
			$table->text('rejectReason')->nullable();
			$table->text('fm_rejectReason')->nullable();
			$table->integer('claim_id')->unsigned();
			$table->timestamps();
			$table->foreign('claim_id')
					->references('id')
					->on('claims')
					->onDelete('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('otClaim');
	}

}