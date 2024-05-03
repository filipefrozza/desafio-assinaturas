<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CreateRoutePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-permission-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a permission routes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            if ($route->getName() != '' && $route->getAction()['middleware']['0'] == 'api') {
                $permission = Permission::where('name', $route->getName())->first();

                if (is_null($permission)) {
                    permission::create(['name' => $route->getName()]);
                }
            }
            
            if (
                str_starts_with($route->uri(), 'api/') 
                && !str_contains($route->uri(), 'roles')
                && !str_contains($route->uri(), 'permissions')
                && !str_contains($route->uri(), 'login')
            ) {
                $permissionsName = $this->generatePermissions($route);
                $this->info("Permission created: $permissionsName");
            }
        }

        $this->info('Permission routes added successfully.');
    }
    
    private function generatePermissions($route)
    {
        $permissions = [];
        $method = $route->methods()[0];
        $model = explode('/', $route->uri())[1];
        if($method == 'GET') {
            $permissions[] = $model . '.view';
            $permissions[] = $model . '.show';
            $permissions[] = $model . '.index';
            Permission::firstOrCreate(['name' => $model . '.view']);
            Permission::firstOrCreate(['name' => $model . '.show']);
            Permission::firstOrCreate(['name' => $model . '.index']);
        } elseif($method == 'POST') {
            $permissions[] = $model . '.create';
            $permissions[] = $model . '.store';
            Permission::firstOrCreate(['name' => $model . '.create']);
            Permission::firstOrCreate(['name' => $model . '.store']);
        } elseif($method == 'PUT') {
            $permissions[] = $model . '.update';
            $permissions[] = $model . '.edit';
            Permission::firstOrCreate(['name' => $model . '.update']);
            Permission::firstOrCreate(['name' => $model . '.edit']);
        } elseif($method == 'DELETE') {
            $permissions[] = $model . '.destroy';
            $permissions[] = $model . '.delete';
            Permission::firstOrCreate(['name' => $model . '.destroy']);
            Permission::firstOrCreate(['name' => $model . '.delete']);
        }
        return implode(',', $permissions);
    }
}