<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class ConstantsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);

        // create roles and assign created permissions

        $superAdminRole = Role::create(['name' => 'super-admin'])
        ->givePermissionTo(Permission::all());

        $moderatorRole = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['publish articles', 'unpublish articles', 'create users']);

        $writerRole = Role::create(['name' => 'writer'])
            ->givePermissionTo('edit articles');

        $superAdmin = User::create([
            'name' =>  $_ENV['ADMIN_NAME'],
            'email' => $_ENV['ADMIN_MAIL'],
            'password' => bcrypt( $_ENV['ADMIN_PASSWORD']),
            'activation_token' => str_random(60),
            'active' => true
        ]);

        $testUser = User::create([
            'name' =>  'Test',
            'email' => 'test@test',
            'password' => bcrypt( $_ENV['ADMIN_PASSWORD']),
            'activation_token' => str_random(60),
            'active' => true
        ]);

        $superAdmin->assignRole($superAdminRole);
        $testUser->assignRole($writerRole);
    }
}
