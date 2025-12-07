<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'alamat' => 'Jakarta',
                'password' => bcrypt('admin'),
            ]
        )->addRole('admin');

        User::create(
            [
                'name' => 'Editor1',
                'email' => 'editor1@example.com',
                'alamat' => 'Jakarta',
                'password' => bcrypt('editor1'),
            ]
        )->addRole('editor');

        User::create(
            [
                'name' => 'Editor2',
                'email' => 'editor2@example.com',
                'alamat' => 'Jakarta',
                'password' => bcrypt('editor2'),
            ]
        )->addRole('editor')->givePermission('delete-post');
        
        User::create(
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'alamat' => 'Jakarta',
                'password' => bcrypt('user'),
            ]
        )->addRole('user');
    }
}
