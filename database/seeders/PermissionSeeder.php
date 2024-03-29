<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routeCollection = Route::getRoutes()->get();
        foreach ($routeCollection as $item) {
                $name = $item->action;
                if (!empty($name['as'])) {
                        $permission = $name['as'];

                        $permission = trim(strtolower($permission));
                        $permission = preg_replace('/[\s.,-]+/', '', $permission);
                        $check = Permission::where('name', $permission);

                        if (($check->count() != 0)) {
                                continue;
                        }
                        Permission::create([
                                'name' => $permission
                        ]);
                }
        }
        
    }

    

}
