<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'dosen', 'guard_name' => 'web']);
        Role::create(['name' => 'mahasiswa', 'guard_name' => 'web']);
    }
}