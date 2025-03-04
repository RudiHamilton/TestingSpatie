<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('role-permission.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name');
        return view('role-permission.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=> 'required|email|max:255|unique:users,email',
            'password'=> 'required|string|min:8|max:20',
            'roles'=>'required',
        ]);
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'roles[]'=> $request->role_id,
        ]);
        $user->syncRoles($request->roles);
        return redirect('/users')->with('status','User created successfully with roles');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userRoles = $user->roles->pluck('name','name')->all();
        $roles = Role::pluck('name','name')->all();
        return view('role-permission.user.edit',compact('user','roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'password'=> 'nullable|string|min:8|max:20',
            'roles'=>'required',
        ]);

        $data=  [
            'name'=> $request->name,
            'email'=> $request->email,
        ];
        if(!empty($request->password)){
            $data+=[
                'password'=> Hash::make($request->password),
            ];
        }
             
        $user->update($data);
        $user->syncRoles($request->roles);
        return redirect('/users ')->with('status','User updated data successfully with roles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $userid)
    {
        $user = User::findOrFail($userid);
        $user->each->delete();
        return redirect('users')->with('status','User deleted successfully with their roles');
    }
}
