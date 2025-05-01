<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat permissions
        Permission::create(['name' => 'approve oprek']);
        Permission::create(['name' => 'approve portofolio']);
        Permission::create(['name' => 'view-dashboard']);
        Permission::create(['name' => 'view-courses']);
        Permission::create(['name' => 'submit-assignments']);
        
        // Buat roles dan assign permissions
        Role::create(['name' => 'admin'])->givePermissionTo(['view-dashboard', 'approve oprek', 'approve portofolio']);
        Role::create(['name' => 'dosen'])->givePermissionTo(['view-dashboard', 'view-courses']);
        Role::create(['name' => 'mahasiswa'])->givePermissionTo(['view-dashboard', 'submit-assignments']);
    }
}