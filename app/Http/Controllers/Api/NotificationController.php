<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Fetch all notifications
    public function index(Request $request)
    {
        $status = $request->status;

        $perPage = $request->input('per_page', 10);
        $notifications = Notification::
        /* when($status != 'all', function ($query) use ($status) {
            return $query->where('read', $status);
        })
        -> */
        with('sender','receiver')
        ->orderBy('id', 'desc')

        ->paginate($perPage);

        return response()->json($notifications);

        $notifications = Notification::all();
        return response()->json(['data'=>$notifications]);
    }

    // Fetch notifications for a specific user
    public function userNotifications($userId)
    {
        $notifications = Notification::where('received_id', $userId)->get();
        return response()->json($notifications);
    }

    // Create a new notification
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'value' => 'nullable|string',
            'sender_id' => 'nullable|exists:users,id',
            'received_id' => 'required|exists:users,id',
        ]);

        $notification = Notification::create($validatedData);
        return response()->json($notification, 201);
    }

    // Show a specific notification
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    // Update a notification
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'value' => 'nullable|string',
            'sender_id' => 'nullable|exists:users,id',
            'received_id' => 'nullable|exists:users,id',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update($validatedData);

        return response()->json($notification);
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(null, 204);
    }
}
