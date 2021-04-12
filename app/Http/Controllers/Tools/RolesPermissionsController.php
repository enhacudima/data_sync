<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;

class RolesPermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role_or_permission:admin_roles_permissions');

    }

    public function createRole(Request $request)
    {
        $roleData=$request->data['roleData'];
        $roleDatID=$request->data['roleDatID'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($roleData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:50',
        ],
        [

        ]
    	);
        if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->all()], 422);
                }

        $input = $myRequest->all();
        if($roleDatID){

            $role=Role::where('id',$roleDatID)->first();
            $role->update(
                [
                    'name'=> $input['name'],
                ]
            );

        }else{

            $role=Role::updateOrCreate(
                [
                    'name'=> $input['name'],
                ]
            );
        }


        $role->syncPermissions([]);
        if(is_array($input['permissions'])){
            foreach ($input['permissions'] as $key => $permission) {
                $role->givePermissionTo($permission['id']);
            }
        }
        return response()->json(['success'=>'Added new records.'], 200);
    }
    public function deleteRole($id)
    {
        $role=Role::where('id',$id)->first();
        $role->syncPermissions([]);
        $role->delete();
        return response()->json(['success'=>'Added deleted records.'], 200);
    }


    public function createPermission(Request $request)
    {
        $roleData=$request->data['permissionData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($roleData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255|unique:roles.name',
        ],
        [

        ]
    	);
        if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->all()], 422);
                }

        $input = $myRequest->all();

                $role=Permission::Create(
                    [
                        'name'=> $input['name'],

                    ]
                );

        return response()->json(['success'=>'Added new records.'], 200);
    }

    public function getRoles()
    {
        $data = Role::with('permissions')->get();

        return response()->json($data, 200);
    }
    public function getPermissions()
    {
        $data = Permission::all();

        return response()->json($data, 200);
    }
    public function getUserRoles($key){
        $data = User::where('key',$key)->with('roles')->first();
        $data = $data->roles;
        return response()->json($data, 200);
    }

    public function setUserRoles(Request $request, $key){
        $roles=$request->data['roles'];
        $user = User::where('key',$key)->first();
        $user->syncPermissions([]);
        $user->syncRoles([]);

        if(is_array($roles)){
            foreach ($roles as $key => $role) {
                $user->assignRole($role['name']);
            }
        }
        return response()->json(['success'=>'Remove records.'], 200);
    }

    public function setUserRole($role, $key){
        $user = User::where('key',$key)->first();
        $role = Role::where('name',$role)->first();

        if(isset($user) || isset($role)){
            $user->syncPermissions([]);
            $user->syncRoles([]);
            $user->assignRole($role);
        }

    }
}
