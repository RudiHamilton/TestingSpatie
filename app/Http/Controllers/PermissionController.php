<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;
/**
* Class SubscriptionController
* @package App\Http\Controllers
*/
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct(){
    // add feature to ensure that admin cannot add or remove permissions if they dont have them.
    $this->middleware('permission:Create Permission',options: ['only'=>['create','store']]);
    $this->middleware('permission:View Permission',options: ['only'=>['index']]);
    $this->middleware('permission:Edit Permission',options: ['only'=>['edit','update',]]);
    $this->middleware('permission:Delete Permission',options: ['only'=>['destroy']]);
    }
    public function index() 
    {
        $permissions = Permission::all();
        return view('role-permission.permission.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role-permission.permission.create');
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
                'unique:permissions,name'
        ]);
        Permission::create([
            'name'=>$request->name,
        ]);
        return redirect('permissions')->with('status','Permission created successfully');
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
    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'=>
                'required',
                'string',
                'unique:permissions,name'.$permission->id
        ]);
        $permission->update([
            'name'=>$request->name,
        ]);
        return redirect('permissions')->with('status','Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permissionid)
    {
        $permission = Permission::find($permissionid);
        $permission->delete();
        return redirect('permissions')->with('status','Permission deleted successfully');
    }
}
