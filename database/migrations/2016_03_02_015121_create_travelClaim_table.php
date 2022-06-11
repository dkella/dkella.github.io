<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelClaimTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('travelClaim', function(Blueprint $table)
		{
			$table->increments('id');
            $table->timestamp('date')->useCurrent();
            $table->time('startTime');
            $table->time('endTime');
            $table->double('hour');
            $table->integer('task_id')->unsigned();
            $table->text('travelDesc');
            $table->integer('mileage')->unsigned();
//            $table->double('totalClaim')->unsigned();

            $table->integer('flag')->nullable();
            $table->text('rejectReason')->nullable();
            $table->text('fm_rejectReason')->nullable();
            $table->integer('claim_id')->unsigned();
//            $table->string('plate_id');

			$table->timestamps();

            $table->foreign('claim_id')
                ->references('id')
                ->on('claims')
                ->onDelete('cascade');

//            $table->foreign('plate_id')
//                ->references('plateNo')
//                ->on('vehicles');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('travelClaim');
	}

}