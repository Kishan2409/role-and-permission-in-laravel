<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            if (auth()->user()->hasRole('superadmin')) {
                //
                $user = User::with(['roles'])->select('users.*');
            } else if (auth()->user()->hasRole('admin')) {
                //
                $user = User::with(['roles'])->whereHas('roles', function ($query) {
                    $query->where('slug', '!=', 'superadmin')->withTrashed();
                })->select('users.*');
            } else {

                $user = User::with(['roles'])->whereHas('roles', function ($query) {
                    $query->whereNotIn('slug', ['superadmin', 'admin'])->withTrashed();
                })->select('users.*');
            }

            return DataTables::eloquent($user)
                ->addColumn('action', function ($user) {

                    $editUrl = url('/users/edit', encrypt($user->id));
                    $viewUrl = url('/users/show', encrypt($user->id));
                    $deleteUrl = url('/users/delete', encrypt($user->id));

                    $actions = '';

                    if (auth()->user()->hasPermission('users.show')) {
                        $actions .= "<a href='" . $viewUrl . "' class='btn btn-success btn-sm m-1 text-decoration-none '><i class='fa-regular fa-folder-open'></i> View</a>";
                    }
                    if (auth()->user()->hasPermission('users.edit')) {
                        $actions .= "<a href='" . $editUrl . "' class='btn btn-primary btn-sm m-1 text-decoration-none '><i class='fas fa-pencil-alt'></i> Edit</a>";
                    }
                    if (auth()->user()->hasPermission('users.delete')) {
                        $actions .= "<a href='" . $deleteUrl . "' class='btn btn-danger btn-sm m-1 text-decoration-none  delete' id='delete' data-id='" . $user->id . "'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                    }

                    return $actions;
                })->addColumn('roles', function ($user) {

                    return $user->roles->first() ? $user->roles->first()->name : '';
                })
                ->rawColumns(['action', 'roles'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if ($request->ajax()) {
            $id = $request->roleid;
            $approved = PermissionRole::where('role_id', $id)->pluck('permission_id')->toArray();
            $permissions = Permission::whereIn('id', $approved)->get()->groupBy('model');
            // Return permissions as JSON response
            return response()->json(['permissions' => $permissions]);
        }
        $role = Role::all();

        return view('user.form', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        //permissions
        $permission = $request->permission;

        $user->save();
        //attachRole
        $user->attachRole($request->role);
        //attachPermission
        $user->attachPermission($permission);

        return redirect('/users')->with('success', 'User added successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::findOrFail(decrypt($id));

        // Get the role ID of the user
        $roleId = !empty($data->roles->first()->id) ? $data->roles->first()->id : '***';

        // Get the approved permissions for the role
        $approved = PermissionRole::where('role_id', $roleId)->pluck('permission_id')->toArray();

        // Group permissions by model
        $permissions = Permission::whereIn('id', $approved)->get()->groupBy('model');

        // Get the approved permissions for the user
        $approvedUserPermissions = PermissionUser::where('user_id', $data->id)->pluck('permission_id')->toArray();

        // Pass data to the view
        $role = Role::all();

        return view('user.show', compact('role', 'data', 'approved', 'permissions', 'approvedUserPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //find user
        $data = User::findOrFail(decrypt($id));

        // Get the role ID of the user
        $roleId = !empty($data->roles->first()->id) ? $data->roles->first()->id : '***';

        // Get the approved permissions for the role
        $approved = PermissionRole::where('role_id', $roleId)->pluck('permission_id')->toArray();

        // Group permissions by model
        $permissions = Permission::whereIn('id', $approved)->get()->groupBy('model');

        // Get the approved permissions for the user
        $approvedUserPermissions = PermissionUser::where('user_id', $data->id)->pluck('permission_id')->toArray();

        // Pass data to the view
        $role = Role::all();

        return view('user._form', compact('role', 'data', 'approved', 'permissions', 'approvedUserPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //get user current role
        $userCurrentRole = User::where('id', decrypt($id))->first();
        //update user
        $user =  User::where('id', decrypt($id))->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $permissions = $request->permission;


        if ($userCurrentRole->roles->first()->id != $request->role) {
            //attachRole
            $role = Role::find($request->role); // Assuming role ID is provided in the request
            $user->roles()->detach(); // Detach any existing roles
            $user->roles()->attach($role); // Attach the new role
        }
        $user->save();
        //permission save in permission_role table
        $user->syncPermissions($permissions);

        //user password update
        if (!empty($request->password)) {
            User::where('id', decrypt($id))->update(['password' => Hash::make($request->password)]);
        }
        return redirect('/users')->with('success', 'User update successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find user
        $user =  User::find($id);
        //delete user
        $user->delete();
        //detach all user permissions on permission_user table
        $user->detachAllPermissions();
        //return response true
        return response()->json(['status' => true]);
    }

    public function checkemail_add(Request $request)
    {
        $email = $request->email;
        $exists = User::where('email', $email)->exists();
        if ($exists) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function checkemail_edit(Request $request)
    {

        $id = $request->id;
        $email = $request->email;
        $exists = User::where('email', $email)->where('id', '!=', $id)->doesntExist();
        return response()->json($exists);
    }
}
