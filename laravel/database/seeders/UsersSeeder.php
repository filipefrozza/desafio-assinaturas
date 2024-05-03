<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
        
        $user = User::create([
            'name' => 'Filipe Frozza',
            'email' => 'admin@example.com',
            'username' => 'root',
            'password' => Hash::make('password')
        ]);
     
        $user->assignRole([$role->id]);
        
        $role = Role::create(['name' => 'user']);
        
        $user = User::create([
            'name' => 'Test user',
            'email' => 'test@example.com',
            'username' => 'test',
            'password' => Hash::make('password')
        ]);
     
        $user->assignRole([$role->id]);
    }
}
