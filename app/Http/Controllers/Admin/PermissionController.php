<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission; 
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar; 

class PermissionController extends Controller {
    
    public function index() {
        $permissions = Permission::all();
        $groupedPermissions = $permissions->groupBy('group'); 
        return view('admin.permission.index', compact('groupedPermissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:permissions,name', 
            'display_name' => 'required',
            'group' => 'required'
        ]);

        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'group' => $request->group, 
            'guard_name' => 'web'
        ]);

        // Cache clear
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Permission created!');
    }
    public function update(Request $request, $id) {
    $permission = Permission::findOrFail($id);
    

    $request->validate([
        'name' => 'required|unique:permissions,name,'.$id, 
        'display_name' => 'required',
        'group' => 'required'
    ]);

    $permission->update([
        'name' => $request->name,
        'display_name' => $request->display_name,
        'group' => $request->group
    ]);

    app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    return redirect()->back()->with('success', 'Permission updated successfully!');
}
public function destroy($id) {
 
    $permission = Permission::findOrFail($id);
    
    
    $permission->delete();

 
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    return redirect()->back()->with('success', 'Permission deleted successfully!');
}
}