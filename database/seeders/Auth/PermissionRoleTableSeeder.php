<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Create Roles
        $super_admin = Role::firstOrCreate(['name' => 'super admin']);
        $admin = Role::firstOrCreate(['name' => 'administrator']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $executive = Role::firstOrCreate(['name' => 'executive']);
        $pengawas = Role::firstOrCreate(['name' => 'pengawas']);
        $hss = Role::firstOrCreate(['name' => 'hss']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Create Permissions
        Permission::firstOrCreate(['name' => 'view_backend']);
        Permission::firstOrCreate(['name' => 'edit_settings']);
        Permission::firstOrCreate(['name' => 'view_logs']);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        \Artisan::call('auth:permission', [
            'name' => 'posts',
        ]);
        echo "\n _Posts_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'categories',
        ]);
        echo "\n _Categories_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'tags',
        ]);
        echo "\n _Tags_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'comments',
        ]);
        echo "\n _Comments_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'tankers',
        ]);
        echo "\n _Tankers_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'inspections',
        ]);
        echo "\n _Inspections_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'days',
        ]);
        echo "\n _Days_ Permissions Created.";

        echo "\n\n";

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo('view_backend');
        $executive->givePermissionTo('view_backend');

        $this->pengawasPermission($pengawas);
        $this->hssPermission($hss);


        Schema::enableForeignKeyConstraints();
    }

    private function pengawasPermission($pengawas){

        Permission::firstOrCreate(['name' => 'approve_by_pengawas']);

        $pengawas->givePermissionTo([
            'view_backend',
            'approve_by_pengawas',
            'view_inspections',
            'view_days',
            'add_days',
            'edit_days',
            'edit_inspections'
        ]);
    }

    private function hssPermission($hss){

        Permission::firstOrCreate(['name' => 'approve_by_hss']);

        $hss->givePermissionTo([
            'view_backend',
            'approve_by_hss',
            'view_inspections',
            'view_days',
            'edit_days',
            'edit_inspections'
        ]);
    }
}
