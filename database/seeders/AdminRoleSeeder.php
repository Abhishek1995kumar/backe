<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminRoleSeeder extends Seeder {
    public function run() {
        DB::table('admin_roles')->truncate();
        DB::table('admin_roles')->insert([
            array(
                'role_name' => 'Super Admin',
                'role_slug' => 'superadmin',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Admin',
                'role_slug' => 'admin',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Grossory Department Head',
                'role_slug' => 'grossorydepartmenthead',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Medical Department Head',
                'role_slug' => 'medicaldepartmenthead',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Marketing Management',
                'role_slug' => 'marketingmanagement',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Operations Management',
                'role_slug' => 'operationsmanagement',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Accounting and Finance',
                'role_slug' => 'accountingandfinance',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Research and Development (R&D)',
                'role_slug' => 'researchanddevelopment',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'Production Head',
                'role_slug' => 'productionhead',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'senior developer',
                'role_slug' => 'seniordeveloper',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'senior developer',
                'role_slug' => 'seniordeveloper',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'junior developer',
                'role_slug' => 'juniordeveloper',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'team lead',
                'role_slug' => 'teamlead',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'role_name' => 'intern',
                'role_slug' => 'intern',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ]);
    }
}



