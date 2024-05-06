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
            'codigo' => 'admin',
            'telefone' => '51981088935',
            'password' => Hash::make('password')
        ]);
     
        $user->assignRole([$role->id]);
        
        $role = Role::create(['name' => 'user']);
        
        $role->givePermissionTo('users.info');
        $role->givePermissionTo('assinaturas.info');
        $role->givePermissionTo('faturas.info');
        
        $user = User::create([
            'name' => 'Test user',
            'email' => 'test@example.com',
            'username' => 'test',
            'codigo' => '000001',
            'telefone' => '11999999999',
            'password' => Hash::make('password')
        ]);
     
        $user->assignRole([$role->id]);
        
        $user = User::create([
            'name' => 'Cliente basico',
            'email' => 'cliente.basico@example.com',
            'username' => 'cliente.basico',
            'codigo' => '000002',
            'telefone' => '11999999998',
            'password' => Hash::make('password')
        ]);
        
        $user->assignRole([$role->id]);
        
        $user = User::create([
            'name' => 'Cliente padrão',
            'email' => 'cliente.padrao@example.com',
            'username' => 'cliente.padrao',
            'codigo' => '000003',
            'telefone' => '11999999997',
            'password' => Hash::make('password')
        ]);
        
        $user->assignRole([$role->id]);
        
        $user = User::create([
            'name' => 'Cliente premium',
            'email' => 'cliente.premium@example.com',
            'username' => 'cliente.premium',
            'codigo' => '000004',
            'telefone' => '11999999996',
            'password' => Hash::make('password')
        ]);
        
        $user->assignRole([$role->id]);
    }
}
