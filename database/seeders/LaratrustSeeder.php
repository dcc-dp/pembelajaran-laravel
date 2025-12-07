<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);
        $editor = Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
        ]);
        $user = Role::create([
            'name' => 'user',
            'display_name' => 'User',
        ]);

        $view = Permission::create([
            'name' => 'view-post',
            'display_name' => 'View Post',
        ]);
        $create = Permission::create([
            'name' => 'create-post',
            'display_name' => 'Create Post',
        ]);
        $edit = Permission::create([
            'name' => 'edit-post',
            'display_name' => 'Edit Post',
        ]);
        $delete = Permission::create([
            'name' => 'delete-post',
            'display_name' => 'Delete Post',
        ]);

        $admin->givePermissions([$view, $create, $edit, $delete]);
        $editor->givePermissions([$view, $edit]);
        $user->givePermissions([$view]);
    }
}
