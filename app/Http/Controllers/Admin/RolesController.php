<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    public function index()
    {
    
        $roles = Role::all();
        $allPermissions = Permission::all();
        
    
        $groupedPermissions = $allPermissions->groupBy(function ($permission) {
            $parts = explode('-', $permission->name, 2);
            return $parts[1] ?? $parts[0]; 
        });

        $rolesWithPermissions = $roles->map(function ($role) {
            $role->current_permission_ids = $role->permissions->pluck('id')->toArray();
            return $role;
        });

        return view('admin.role_management', [
            'roles' => $rolesWithPermissions,
            'permissionsByGroup' => $groupedPermissions, 
        ]);
    }

    public function updatePermissions(Request $request)
    {
        $permissionsData = $request->input('permissions', []);
        
        foreach ($permissionsData as $roleId => $permissionMap) {
            // Role::findById() 
            $role = Role::findById($roleId);
            
            if (!$role) {
                continue;
            }

            $newPermissions = [];

            foreach ($permissionMap as $permissionId => $value) {
                // chackbox  click ketedrge (Value 1 )
                if ($value == 1) {
                    $newPermissions[] = $permissionId;
                }
            }

           //remove old permission then add new permission
            $role->syncPermissions($newPermissions);
        }


        return redirect()->route('roles.index')->with('success', 'Role permissions updated successfully.');
    }
}