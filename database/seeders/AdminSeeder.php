<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Admin\AdminDepartmentMaster;
use App\Models\Admin\AdminDesignationMaster;
use App\Models\Admin\AdminRole;

class AdminSeeder extends Seeder {
    public function run() {
        $depId = AdminDepartmentMaster::where('departments', 'Employee Benefits')->value('id');
        $desId = AdminDesignationMaster::where('designation', 'CEO')->value('id');
        $rolId = AdminRole::where('role_slug', 'superadmin')->value('id');

        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            array(
                'department_id' => $depId,
                'designation_id' => $desId,
                'role_id' => $rolId,
                'code' => 'EMP101',
                'name' => 'Abhishek Kumar',
                'phone' => '9415058209',
                'email' => 'annaaryan95@gmail.com',
                'gender' => '1',
                'status' => '1',
                'default_password' => 'Abhishek@123',
                'password' => Hash::make('Abhishek@123'),
                'token' => null,
                'password_modified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL,
            ),
            array(
                'department_id' => $depId,
                'designation_id' => $desId,
                'role_id' => $rolId,
                'code' => 'EMP102',
                'name' => 'Komal Abhishek',
                'phone' => '9415058209',
                'email' => 'komal05@gmail.com',
                'gender' => '2',
                'status' => '1',
                'default_password' => 'Abhishek@123',
                'password' => Hash::make('Abhishek@123'),
                'token' => null,
                'password_modified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL,
            ),
        ]);

    }
}
