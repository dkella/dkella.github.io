<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$admin_role = DB::table('roles')
                                ->select('id')
                                ->where('role','admin')
                                ->first()
                                ->id;

		$staff_role = DB::table('roles')
                                ->select('id')
                                ->where('role','staff')
                                ->first()
                                ->id;

		$sv_role = DB::table('roles')
                                ->select('id')
                                ->where('role','supervisor')
                                ->first()
                                ->id;

		$fc_role = DB::table('roles')
                                ->select('id')
                                ->where('role','financial clerk')
                                ->first()
                                ->id;

		$fm_role = DB::table('roles')
                                ->select('id')
                                ->where('role','financial manager')
                                ->first()
                                ->id;

		$dept_acc = DB::table('departments')
                                ->select('id')
                                ->where('department','Penbendaharaan')
                                ->first()
                                ->id;

		$dept_enforcement = DB::table('departments')
                                ->select('id')
                                ->where('department','Penguatkuasaan')
                                ->first()
                                ->id;

        DB::table('users')->insert(
          array(
              array(
                  'name' => 'admin1',
                  'noKP' => '610318055385',
                  'email' => 'admin@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => '',
                  'dept_id' => $dept_acc,
                  'branch' => '',
                  'homeAddress' => '',
                  'salary' => '',
              ),
              array(
                  'name' => 'Mustaffa Bin Ismail',
                  'noKP' => '570929025295',
                  'email' => 'staff@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => 'Pembantu Penguatkuasa N17',
                  'dept_id' => $dept_enforcement,
                  'branch' => 'Cawangan Munsyi Ibrahim',
                  'homeAddress' => 'No 122, Jalan Ciku,Taman Baru, 81800 Ulu Tiram, Johor.',
                  'salary' => 2059.01,
              ),
              array(
                  'name' => 'Mohammad Afiq Bin Ahamad',
                  'noKP' => '870920015235',
                  'email' => 'staff2@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => 'Pembantu Penguatkuasa N17',
                  'dept_id' => $dept_enforcement,
                  'branch' => 'Cawangan Munsyi Ibrahim',
                  'homeAddress' => 'No 70, Jalan kebudayaan,Taman Universiti, 81300 Skudai, Johor.',
                  'salary' => 1809.05,
              ),
              array(
                  'name' => 'supervisor1',
                  'noKP' => '571020025295',
                  'email' => 'sv@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => 'Penyelia Penguatkuasaan N17',
                  'dept_id' => $dept_enforcement,
                  'branch' => 'Cawangan Munsyi Ibrahim',
                  'homeAddress' => 'No 122, Jalan Ciku,Taman Baru, 81800 Ulu Tiram, Johor.',
                  'salary' => 2059.01,
              ),
              array(
                  'name' => 'Financial Clerk1',
                  'noKP' => '550429025295',
                  'email' => 'fc@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => 'Setiausaha Kewangan',
                  'dept_id' => $dept_acc,
                  'branch' => 'Cawangan Munsyi Ibrahim',
                  'homeAddress' => 'No 122, Jalan Ciku,Taman Baru, 81800 Ulu Tiram, Johor.',
                  'salary' => 2059.01,
              ),
              array(
                  'name' => 'Financial Manager1',
                  'noKP' => '521024025295',
                  'email' => 'fm@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => 'Pengurus Kewangan',
                  'dept_id' => $dept_acc,
                  'branch' => 'Cawangan Munsyi Ibrahim',
                  'homeAddress' => 'No 122, Jalan Ciku,Taman Baru, 81800 Ulu Tiram, Johor.',
                  'salary' => 6059.01,
              ),
              array(
                  'name' => 'Staff Kella',
                  'noKP' => '930907055626',
                  'email' => 'staff_kella@example.com',
                  'password' => \Illuminate\Support\Facades\Hash::make('password'),
                  'position' => 'Pembantu Penguatkuasa N17',
                  'dept_id' => $dept_enforcement,
                  'branch' => 'Cawangan Munsyi Ibrahim',
                  'homeAddress' => 'No 123,Taman Kebudayaan, 81200 Skudai, Johor.',
                  'salary' => 1854.20,
              ),

          )
        );

        DB::table('role_user')->insert(
            array(
                array(
                    'user_id' => 1,
                    'role_id' => $admin_role
                ),
                array(
                    'user_id' => 2,
                    'role_id' => $staff_role
                ),
                array(
                    'user_id' => 3,
                    'role_id' => $staff_role
                ),
                array(
                    'user_id' => 4,
                    'role_id' => $sv_role
                ),
                array(
                    'user_id' => 5,
                    'role_id' => $fc_role
                ),
                array(
                    'user_id' => 6,
                    'role_id' => $fm_role
                ),
                array(
                    'user_id' => 7,
                    'role_id' => $staff_role
                ),
            )
        );

        DB::table('supervision')->insert(
            array(
                array(
                    'staff_id' => 7,  //kella
                    'sv_id' => 4   //supervisor1
                ),
            )
        );

//        DB::table('department_user')->insert(
//            array(
//                array(
//                    'user_id' => 1,
//                    'dept_id' => $dept_acc
//                ),
//                array(
//                    'user_id' => 2,
//                    'dept_id' => $dept_enforcement
//                ),
//                array(
//                    'user_id' => 3,
//                    'dept_id' => $dept_enforcement
//                ),
//                array(
//                    'user_id' => 4,
//                    'dept_id' => $dept_acc
//                ),
//                array(
//                    'user_id' => 5,
//                    'dept_id' => $dept_acc
//                ),
//            )
//        );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB:table('users')->delete();
	}

}