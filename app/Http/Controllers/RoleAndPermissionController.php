<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:manage roles and permissions'); 
    // }

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('Setting.role_permission', compact('roles', 'permissions'));
    }
    // Store a new role
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('roles_permissions.index')->with('success', 'Role created successfully!');
    }

    // Store a new permission
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->route('roles_permissions.index')->with('success', 'Permission created successfully!');
    }

    // Edit role
    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        return view('roles_permissions.edit_role', compact('role', 'permissions'));
    }

    // Update role
    public function updateRole(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|string|max:255']);
    
        $role->name = $request->name;
        $role->save();
    
        return response()->json(['success' => 'Role updated successfully!', 'id' => $role->id, 'name' => $role->name]);
    }
    
    // Delete role
    public function destroyRole(Role $role)
    {
        if($role->delete()){
            return response()->json(['success' => 'Role deleted successfully!']);            
        }else{
            return response()->json(['error' => 'Failed to delete role!']);
        }
    }

    // Edit permission
    public function editPermission(Permission $permission)
    {
        return view('roles_permissions.edit_permission', compact('permission'));
    }

    // Update permission
    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|string|max:255']);
    
        $permission->name = $request->name;
        $permission->save();
    
        return response()->json(['success' => 'Permission updated successfully!', 'id' => $permission->id, 'name' => $permission->name]);
    }
    
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();
    
        return response()->json(['success' => 'Permission deleted successfully!']);
    }
    

    public function assignPermissions(Request $request, Role $role)
    {

        // logger($request->all());

        $request->validate([
            'permissions' => 'required|array', 
            'permissions.*' => 'exists:permissions,name',
            'role_id' => 'required|exists:roles,id',
        ]);

        
        if ($request->role_id != $role->id) {
            return response()->json(['error' => 'Role ID mismatch'], 400);
        }

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json(['success' => 'Permissions assigned successfully!']);
    }
}
