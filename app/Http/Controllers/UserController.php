<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $perPage = $request->input("perPage");
        $search = $request->input("search");

        $users = User::search($search)->latest()->paginate($perPage);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->storeImage($request, 'user') : null;
        $validated['password'] = Hash::make($validated['password']);
        $role = Role::findOrFail($validated["role_id"]);
        $user = User::create($validated);
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

        $validated = $request->validated();
        // $validated['image'] = $request->hasFile('image') ? $this->updateImage($request, $user, 'user') : null;
        $validated['password']=Hash::make($validated['password']);
        $role = Role::findOrFail($validated['role_id']);
        $user->update($validated);
        $user->syncRoles([$role]);

        return new UserResource($user);
    }


    public function updateStatus(Request $request, User $user)
    {
        if ($user->id == Auth::id()) {
            return response()->json(['message' => "You cannot change the active user's status"], 403);
        }

        $request->validate([
            'status' => 'required|boolean',
        ]);

        $user->status = $request->status;
        $user->save();

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
