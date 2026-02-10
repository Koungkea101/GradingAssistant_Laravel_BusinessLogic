<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::select('id', 'name', 'email', 'created_at')->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Get validated data from the form request
        $validatedData = $request->validated();

        // Hash the password
        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = Users::create($validatedData);

        return response()->json([
            'message' => 'User ' . $user->name . ' created successfully',
            'user' => $user->only(['id', 'name', 'email', 'phone', 'role', 'is_active', 'created_at'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Users::findOrFail($id);

        return response()->json([
            'user' => $user->only(['id', 'name', 'email', 'phone', 'role', 'is_active', 'created_at'])
        ]);
    }

    /**
     * Display the specified resource for profile.
     */
    public function showProfile(Users $users)
    {
        return response()->json([
            'user' => $users->only(['id', 'name', 'email', 'phone', 'role', 'is_active', 'created_at'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = Users::findOrFail($id);

        // Get validated data from the form request
        $validatedData = $request->validated();

        // Hash the password if it's being updated
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'User ' . $user->name . ' updated successfully',
            'user' => $user->only(['id', 'name', 'email', 'phone', 'role', 'is_active', 'updated_at'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user or fail with 404
        $user = Users::findOrFail($id);

        // Store the user's name before deletion (fallback to 'Unknown User' if empty)
        $userName = $user->name ?: 'Unknown User';

        $user->delete();

        return response()->json([
            'message' => 'User ' . $userName . ' deleted successfully',
            'deleted_user' => [
                'id' => $user->id,
                'name' => $userName,
                'email' => $user->email
            ]
        ]);
    }
}
