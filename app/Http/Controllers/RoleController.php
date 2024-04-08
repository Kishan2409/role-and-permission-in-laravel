<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $role = Role::select('roles.*');

            return DataTables::eloquent($role)
                ->addColumn('action', function ($role) {

                    $editUrl = url('/role/edit', encrypt($role->id));
                    $viewUrl = url('/role/show', encrypt($role->id));
                    $deleteUrl = url('/role/delete', encrypt($role->id));

                    $actions = '';


                    if (auth()->user()->hasPermission('role.show')) {
                        $actions .= "<a href='" . $viewUrl . "' class='btn btn-success btn-sm m-1 text-decoration-none '><i class='fa-regular fa-folder-open'></i> View</a>";
                    }
                    if (auth()->user()->hasPermission('role.edit')) {
                        $actions .= "<a href='" . $editUrl . "' class='btn btn-primary btn-sm m-1 text-decoration-none '><i class='fas fa-pencil-alt'></i> Edit</a>";
                    }
                    if (auth()->user()->hasPermission('role.delete')) {
                        $actions .= "<a href='" . $deleteUrl . "' class='btn btn-danger btn-sm m-1 text-decoration-none  delete' id='delete' data-id='" . $role->id . "'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                    }
                    return $actions;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permissions = Permission::get()->groupBy('model');
        return view('role.form', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //new role create
        $role = new Role;
        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->level = $request->lavel;
        $permissions = $request->permission;
        $role->save();
        //permission save in permission_role table
        $role->attachPermission($permissions);

        return redirect('/role')->with('success', 'Role added successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Role::where('id', decrypt($id))->first();
        $permissions = Permission::get()->groupBy('model');
        $approved = PermissionRole::where('role_id', decrypt($id))->pluck('permission_id')->toArray();
        return view('role.show', compact('data', 'permissions', 'approved'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Role::where('id', decrypt($id))->first();
        $permissions = Permission::get()->groupBy('model');
        $approved = PermissionRole::where('role_id', decrypt($id))->pluck('permission_id')->toArray();
        return view('role._form', compact('data', 'permissions', 'approved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //update role
        $role =  Role::where('id', decrypt($id))->first();
        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->level = $request->lavel;
        $permissions = $request->permission;
        //role update
        $role->save();

        //permission update in permission_role table
        $role->syncPermissions($permissions);

        //get all user with role and permission
        $usersWithRolesPermissions = User::with(['roles', 'permissions'])->get();

        //loop user
        foreach ($usersWithRolesPermissions as $user) {

            //loop user role
            foreach ($user->roles as $roles) {

                //check user role and update role id is same or not
                if ($roles->id == $role->id) {

                    //check user permission is not empty
                    if (!empty($user->permissions)) {

                        //loop user permission
                        foreach ($user->permissions as $permission) {

                            //check role permissions is not empty
                            if (!empty($permissions)) {

                                //check user permission id is not in role permissions array
                                if (!in_array($permission->id, $permissions)) {

                                    //remove user permission in permission_user table
                                    $user->detachPermission($permission->id);
                                }
                            } else {

                                //role permissions is empty remove all user permission
                                $user->detachAllPermissions();
                            }
                        }
                    }
                }
            }
        }

        return redirect('/role')->with('success', 'Role update successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find role
        $role =  Role::find($id);


        $usersWithRolesPermissions = User::with(['roles', 'permissions'])->get();

        //loop user
        foreach ($usersWithRolesPermissions as $user) {

            //loop user role
            foreach ($user->roles as $roles) {

                //check user role and update role id is same or not
                if ($roles->id == $role->id) {

                    //check user permission is not empty
                    if (!empty($user->permissions)) {

                        //remove all user permission
                        $user->detachAllPermissions();
                    }
                }
            }
        }

        //delete role
        $role->delete();

        //detach all role permissions on permission_role table
        $role->detachAllPermissions();

        //return response true
        return response()->json(['status' => true]);
    }

    public function checkslug_add(Request $request)
    {
        $slug = $request->slug;
        $exists = Role::where('slug', $slug)->withTrashed()->exists();
        if ($exists) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function checkslug_edit(Request $request)
    {

        $id = $request->id;
        $slug = $request->slug;
        $exists = Role::where('slug', $slug)->where('id', '!=', $id)->withTrashed()->doesntExist();
        return response()->json($exists);
    }
}
