<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ImageHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $users= User::search($search)->latest()->paginate($perPage);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated= $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->storeImage($request,'user'):null;
        $role = Role::findOrFail($validated["role_id"]);
        $user= User::create($validated);
        // $user->password = Hash::make($request->input('password'));
        // $user->save();
        $user->assignRole($role);
        
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $validated= $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->updateImage($request,$user,'user'): null;
        $role = Role::findOrFail($validated['role_id']);
        $user->update($validated);
        $user->syncRoles([$role]);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->deleteImage($user);
        $user->delete();
        return new UserResource($user);
    }
}
