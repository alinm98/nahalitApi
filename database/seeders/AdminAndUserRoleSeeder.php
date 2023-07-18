<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminAndUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::query()->create([
            'title' => 'admin'
        ]);

        $admin->permissions()->attach(Permission::all());

        $admin = Role::query()->create([
            'title' => 'user'
        ]);

        User::query()->create([
            'first_name' => 'ali',
            'last_name' => 'nami',
            'username' => 'alinami',
            'mobile' => '09227205827',
            'password' => bcrypt(12345678),
            'email' => 'mail@mail.com',
            'role_id' => 1
        ]);



    }
}
