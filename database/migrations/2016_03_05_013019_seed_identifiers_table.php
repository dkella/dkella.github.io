<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedIdentifiersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('identifiers')->insert(
            array(
           //Month----------------------------------------------------------------
                array(
                    'code' => 1,
                    'name' => 'Januari',
                    'type' => 'month',
                ),
                array(
                    'code' => 2,
                    'name' => 'Februari',
                    'type' => 'month',
                ),
                array(
                    'code' => 3,
                    'name' => 'March',
                    'type' => 'month',
                ),
                array(
                    'code' => 4,
                    'name' => 'April',
                    'type' => 'month',
                ),
                array(
                    'code' => 5,
                    'name' => 'Mei',
                    'type' => 'month',
                ),
                array(
                    'code' => 6,
                    'name' => 'Jun',
                    'type' => 'month',
                ),
                array(
                    'code' => 7,
                    'name' => 'Julai',
                    'type' => 'month',
                ),
                array(
                    'code' => 8,
                    'name' => 'Ogos',
                    'type' => 'month',
                ),
                array(
                    'code' => 9,
                    'name' => 'September',
                    'type' => 'month',
                ),
                array(
                    'code' => 10,
                    'name' => 'Oktober',
                    'type' => 'month',
                ),
                array(
                    'code' => 11,
                    'name' => 'November',
                    'type' => 'month',
                ),
                array(
                    'code' => 12,
                    'name' => 'Disember',
                    'type' => 'month',
                ),

            //Claim Status----------------------------------------------------------------
                array(
                    'code' => 1,
                    'name' => 'draft',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 2,
                    'name' => 'submitted',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 3,
                    'name' => 'approved',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 4,
                    'name' => 'rejected',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 5,
                    'name' => 'verified',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 6,
                    'name' => 'pending',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 7,
                    'name' => 'finance rejected',
                    'type' => 'claim_status',
                ),
                array(
                    'code' => 8,
                    'name' => 'finance pending',
                    'type' => 'claim_status',
                ),

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
        DB:table('identifiers')->delete();
	}

}
