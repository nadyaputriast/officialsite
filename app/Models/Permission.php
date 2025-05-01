<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public static function initializePermissions()
    {
        Permission::create(['name' => 'approve oprek']);
    }
}