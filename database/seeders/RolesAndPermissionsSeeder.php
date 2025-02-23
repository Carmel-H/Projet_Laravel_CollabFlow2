<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Créer les permissions
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'invite user']);
        Permission::create(['name' => 'assign task']);
        Permission::create(['name' => 'view task']);
        Permission::create(['name' => 'join project']);
        
        // Créer les rôles
        $adminRole = Role::create(['name' => 'admin']);
        $memberRole = Role::create(['name' => 'member']);
        
        // Assigner les permissions aux rôles
        $adminRole->givePermissionTo([
            'create project', 'invite user', 'assign task'
        ]);
        
        $memberRole->givePermissionTo([
            'join project', 'view task'
        ]);
    }
}
