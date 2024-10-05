<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePermissionRequest;
use App\Http\Resources\RolePermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware("can:viewHRM")->only(["index", "show"]);
    //     $this->middleware("can:createHRM")->only('store');
    //     $this->middleware("can:editHRM")->only('update');
    //     $this->middleware("can:deleteHRM")->only('destroy');
    // }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $query = Role::query()->where('name', 'like', $search . '%')->latest();
        $roles = $perPage == -1 ? $query->get() : $query->paginate($perPage);

        return RolePermissionResource::collection($roles);
    }

    public function store(RolePermissionRequest $request)
    {
        $validated= $request->validated();
        $permissionsArray = $validated['permissions'];

        // Create or retrieve role
        $newRole = Role::firstOrCreate([
            "name"=> $validated["name"],
             "description"=>  $validated["description"],
             'guard_name' => 'web'
            ]);

        // Create or retrieve each permission and attach them to the role
        foreach($permissionsArray as $permission)
        {
            Permission::firstOrCreate(["name"=>$permission,'guard_name' => 'web']);
        }
        // Assign permissions to the role
        $newRole->syncPermissions($permissionsArray);

        return new RolePermissionResource($newRole);
    }

    public function show($id)
    {
        $role = Role::where('id', $id)->first();
        return new RolePermissionResource($role);
    }

    public function update(RolePermissionRequest $request, $id)
    {
        $validated= $request->validated();
        $permissionsArray = $validated['permissions'];
    
        // Find the role by ID
        $role = Role::where('id', $id)->first();
        $role->name = $validated['name'];
        $role->description = $validated['description'];
    
        // Find or create each permission and sync them with the role
        
        foreach ($permissionsArray as $permission) {
             Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            
        }
    
        // Sync the permissions with the role
        $role->syncPermissions($permissionsArray);
    
        // Save the updated role details
        $role->save();
    
        return new RolePermissionResource($role);
    }
    

    public function destroy($id)
    {
        $role = Role::where('id', $id)->first();
        $role->delete();
        return response()->json(['message' => 'deleted successfully'], 200);
    }

}