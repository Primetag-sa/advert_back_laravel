<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 items per page if not specified
        $users = User::orderBy('id','desc')->paginate($perPage);

        $users->getCollection()->transform(function ($user) {
            $user->image_url = asset($user->image); // Assuming you store image paths in 'image_path' field
            return $user;
        });

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password??'password'),
            'is_confirmed' => false,
            'role'=>'agency'
        ]);

        $agency = Agency::create([
            'name'=>$user->agencyName,
            'user_id'=>$user->id,
            'tiktok_url'=>$request->tiktok_url,
            'facebook_url'=>$request->facebook_url,
            'instagram_url'=>$request->instagram_url,
            'snapchat_url'=>$request->snapchat_url,
            'x_url'=>$request->x_url,
        ]);

        return response()->json($agency, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            'role' => $request->role,
            'permissions' => $request->permissions,
            'is_confirmed' => $request->is_confirmed,
            'confirmed_at' => $request->confirmed_at,
            'is_activated' => $request->is_activated,
            'activated_at' => $request->activated_at,
            'token' => $request->token,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete related agents
        $user->agent()->delete(); // Assuming you have a relationship defined in the User model

        // Delete related agencies
        $user->agency()->delete(); // Assuming you have a relationship defined in the User model

        // Now delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

}
