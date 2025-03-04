<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index() 
    {
        $roles = Role::all();
        return view('role-permission.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role-permission.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 
                'required',
                'string',
                'unique:roles,name'
        ]);
        Role::create([
            'name'=>$request->name,
        ]);
        return redirect('roles')->with('status','Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('role-permission.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>
                'required',
                'string',
                'unique:roles,name'.$role->id
        ]);
        $role->update([
            'name'=>$request->name,
        ]);
        return redirect('roles')->with('status','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roleid)
    {
        $role = Role::findOrFail($roleid);
        $role->delete();
        return redirect('roles')->with('status','Role deleted successfully');
    }
    public function addPermissionToRole($roleid){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleid);

        $rolePermission = DB::table('role_has_permissions')
        ->where('role_has_permissions.role_id',$role->id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        return view('role-permission.role.addpermission',[
            'role'=>$role,
            'permissions'=>$permissions,
            'rolePermission'=>$rolePermission,
        ]);
    }
    public function givePermissionToRole(Request $request, $roleid){
        $request -> validate([
            'permission'=>'required',
        ]);
        $role = Role::findOrFail($roleid);
        $role->syncPermissions($request->permission);
        
        return redirect()->back()->with('status','Permissions added to role');
    }
}
