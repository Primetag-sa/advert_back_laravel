<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function changeStatus(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {

            if ($request->status == 'canceled') {
                $user->is_confirmed = 0;
            }

            if ($request->status == 'activated') {
                $user->is_confirmed = 1;
            }
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'تم الحفظ']);
        }

        return response()->json(['status' => 'error', 'message' => 'حدث خطا ما']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->role;
        $status = $request->status;
        $user = Auth::user();
        $agencyId = $user->id;
        if (! $request->status) {
            $status = 'all';
        }
        if (! $request->role) {
            $role = 'agency';
        }
        $perPage = $request->input('per_page', 10);

        $users = User::where('role', $role)
            ->when($status != 'all', function ($query) use ($status) {
                return $query->where('is_confirmed', $status);
            })
            ->when($role == 'agent', function ($query) use ($agencyId) {
                return $query->whereHas('agent', function ($q) use ($agencyId) {
                    $q->where('agency_id', $agencyId);
                });
            })
            ->with('agency', 'agent', 'admin')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($users);
    }

    public function agencyAgents(Request $request)
    {

        $user = Auth::user();

        $status = $request->status;
        if (! $request->status) {
            $status = 'all';
        }
        $perPage = $request->input('per_page', 10);

        $users = User::where('role', 'agent')
            ->when($status != 'all', function ($query) {
                return $query->where('is_confirmed', true);
            })
            ->whereHas('agent', function ($query) use ($user) {
                $query->where('agency_id', $user->id);
            })
            ->with('agency', 'agent', 'admin')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

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

        $role = $request->role ?? 'agency';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password ?? 'password'),
            'is_confirmed' => false,
            'role' => $role,
        ]);
        if ($role == 'agency') {
            $agency = Agency::create([
                'name' => $request->agencyName,
                'user_id' => $user->id,
                'tiktok_url' => $request->tiktok_url,
                'address' => $request->address,
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'snapchat_url' => $request->snapchat_url,
                'x_url' => $request->x_url,
            ]);
        }

        if ($role == 'agent') {
            if ($request->from == 'agency') {
                // $agency_id = User::find($request->agencyId)?->agency?->id;
                $agency = Agent::create([
                    'name' => $request->agencyName,
                    'user_id' => $user->id,
                    'agency_id' => $request->from == 'agency' ? User::find($request->agencyId)?->agency?->id : $request->agencyId,
                    'tiktok_url' => $request->tiktok_url,
                    'address' => $request->address,
                    'facebook_url' => $request->facebook_url,
                    'instagram_url' => $request->instagram_url,
                    'snapchat_url' => $request->snapchat_url,
                    'x_url' => $request->x_url,
                ]);
            }
        }

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::where('id', $id)->with('agency', 'admin', 'agent')->first();
        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'حدث خطا ما']);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'حدث خطا ما']);
        }

        $request->validate([
            // 'name' => 'required|string|max:255',
            // 'email' => [
            //     'required',
            //     'string',
            //     'email',
            //     'max:255',
            //     Rule::unique('users')->ignore($user->id),
            // ],
            // 'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            // 'role' => 'agency',
            // 'permissions' => $request->permissions,
            // 'is_confirmed' => $request->is_confirmed,
            // 'confirmed_at' => $request->confirmed_at,
            // 'is_activated' => $request->is_activated,
            // 'activated_at' => $request->activated_at,
            // 'token' => $request->token,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        $data = [
            'name' => $request->agencyName ?? ' ',
            'user_id' => $id,
            'address' => $request->address ?? '-',
            'tiktok_url' => $request->tiktok_url ?? ' ',
            'facebook_url' => $request->facebook_url ?? ' ',
            'instagram_url' => $request->instagram_url ?? ' ',
            'snapchat_url' => $request->snapchat_url ?? ' ',
            'x_url' => $request->x_url ?? ' ',
        ];
        $agency = $user->agency;

        if ($user->role == 'agency') {
            if ($agency) {
                $agency->update($data);
            } else {
                Agency::create($data);
            }
        }
        if ($user->role == 'agent') {
            if ($user->agent) {
                $user->agent->update($data);
            } else {
                Agency::create($data);
            }
        }

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
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