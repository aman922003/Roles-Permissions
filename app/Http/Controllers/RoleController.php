<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
     /**
     * Assign Permissions using Middleware.
     */
    public static function middleware()
    {
        return[
            new Middleware('permission:view roles',only: ['index']),
            new Middleware('permission:edit roles',only: ['edit']),
            new Middleware('permission:create roles',only: ['create']),
            new Middleware('permission:delete roles',only: ['destroy']),
        ];
    }
    //This method will shows Role page
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate(10);
        return view('roles.list', [
            'roles' => $roles
        ]);
    }

    //This method will shows create role page
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    //This method will shows insert roles in DB
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:roles|min:3'
            ]
        );
        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.index')->with('success', 'roles added successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    //This method will shows Edit roles page
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermission = $role->permissions->pluck('name');
        $permission = Permission::orderBy('name', 'ASC')->get();
        return view('roles.edit', [
            'permissions' => $permission,
            'hasPermissions' => $hasPermission,
            'role' => $role
        ]);
    }

    //This method will shows update roles.
    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:roles,name,' . $id
            ]
        );
        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();
            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]); 
            }
            return redirect()->route('roles.index')->with('success', 'Roles updated successfully');
        } else {
            return redirect()->route('roles.edit')->withInput()->withErrors($validator);
        }
    }

    //This method will delete roles in DB.
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);
        if ($role == null) {
            session()->flash('error', 'Role Not Found');
            return response()->json([
                'status' => false
            ]);
        }
        $role->delete();
        session()->flash('success', 'Role Deleted Successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
