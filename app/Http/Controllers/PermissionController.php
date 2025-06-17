<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PermissionController extends Controller implements HasMiddleware
{
     /**
     * Assign Permissions using Middleware.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }

    //This method will shows permissions page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('permissions.list', [
            'permissions' => $permissions
        ]);
    }

    //This method will shows create permissions page
    public function create()
    {
        return view('permissions.create');
    }

    //This method will shows insert permissions in DB
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:permissions|min:3'
            ]
        );
        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'permissions added successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    //This method will shows Edit permissions page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

    //This method will shows update permissions.
    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|unique:permissions,name,' . $id . ',id'
            ]
        );
        // dd('hello');
        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'permissions updated successfully');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    //This method will delete permissions in DB.
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);
        if ($permission == null) {
            session()->flash('error', 'Permission Not Found');
            return response()->json([
                'status' => false
            ]);
        }
        $permission->delete();
        session()->flash('success', 'Permission Deleted Successfully');
        return response()->json([
            'status' => true
        ]);
    }
}