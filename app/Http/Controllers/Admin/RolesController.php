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

   public function updateSinglePermission(Request $request)
{
    try {
        $roleId = $request->input('role_id');
        $permissionId = $request->input('permission_id');
        $status = $request->input('status'); 

        $role = Role::findById($roleId);
        $permission = Permission::findById($permissionId);

        if ($status == 1) {
            $role->givePermissionTo($permission);
        } else {
            $role->revokePermissionTo($permission);
        }

        // this is permission automatically take value and clear catch
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return response()->json([
            'status' => 'success',
            'message' => 'Permission updated successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
}