<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers\Api;

use App\Enum\NotificationType;
use App\Http\Controllers\Trait\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationsResource;
use App\Models\Notification;
use App\Models\ReadNotifications;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    // Fetch all notifications
    // public function index(Request $request)
    // {
    //     // $status = $request->status;

    //     $perPage = $request->input('per_page', 10);
    //     // $notifications = Notification::
    //     /* when($status != 'all', function ($query) use ($status) {
    //         return $query->where('read', $status);
    //     })
    //     -> */
    //     // with('sender','receiver')
    //     // ->orderBy('id', 'desc')

    //     ->paginate($perPage);

    //     return response()->json($notifications);

    //     $notifications = Notification::all();
    //     return response()->json(['data'=>$notifications]);
    // }

    // Fetch notifications for a specific user
    // public function userNotifications($userId)
    // {
    //     $notifications = Notification::where('received_id', $userId)->get();
    //     return response()->json($notifications);
    // }

    // Create a new notification
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'message' => 'required|string',
    //         'value' => 'nullable|string',
    //         'sender_id' => 'nullable|exists:users,id',
    //         'received_id' => 'required|exists:users,id',
    //     ]);

    //     $notification = Notification::create($validatedData);
    //     return response()->json($notification, 201);
    // }

    // Show a specific notification
    // public function show($id)
    // {
    //     $notification = Notification::findOrFail($id);
    //     return response()->json($notification);
    // }

    // Update a notification
    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'nullable|string|max:255',
    //         'message' => 'nullable|string',
    //         'value' => 'nullable|string',
    //         'sender_id' => 'nullable|exists:users,id',
    //         'received_id' => 'nullable|exists:users,id',
    //     ]);

    //     $notification = Notification::findOrFail($id);
    //     $notification->update($validatedData);

    //     return response()->json($notification);
    // }

    // Delete a notification
    // public function destroy($id)
    // {
    //     $notification = Notification::findOrFail($id);
    //     $notification->delete();

    //     return response()->json(null, 204);
    // }


    public function index()
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $notifications = Notification::all();
            } elseif ($user->role === 'agency') {
                $notifications = Notification::where('type', NotificationType::AGENCY)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('notifiable_id', $user->agency_id)
                            ->where('notifiable_type', 'App\Models\Agency');
                    })
                    ->get();

            } elseif ($user->role === 'user') {
                $notifications = Notification::where('type', NotificationType::SYSTEM)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('notifiable_id', $user->id)
                            ->where('notifiable_type', 'App\Models\User');
                    })
                    ->get();
            } else {
                $notifications = collect();
            }

            return $this->apiResponseSuccess(NotificationsResource::collection($notifications));
        } catch (\Exception $e) {

            return $this->ApiResponseFaild('error', $e->getMessage(), 500);
        }
    }


    public function markRead(Request $request)
    {
        try {
            ReadNotifications::create([
                'user_id' => auth()->user()->id,
                'notifications_id' => $request->notificationId->id,
            ]);

            return $this->ApiResponseSuccessInsert();
        } catch (\Exception $e) {

            return $this->ApiResponseFaild('error', $e->getMessage(), 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $user = auth()->user();

            $unreadNotifications = Notification::where('type', NotificationType::AGENCY)
                ->orWhere(function ($query) use ($user) {
                    $query->where('notifiable_id', $user->id)
                        ->where('notifiable_type', 'App\Models\Agency');
                })
                ->get();

            foreach ($unreadNotifications as $notification) {
                ReadNotifications::create([
                    'user_id' => auth()->id(),
                    'notification_id' => $notification->id,
                ]);
                $notification->update(['is_read' => true]);
            }

            return $this->ApiResponseSuccessInsert();
        } catch (\Exception $e) {
            return $this->ApiResponseFaild('error', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:system,agency,user',
            'user_id' => 'nullable',
        ]);
        if (!auth()->user()) {

            return $this->ApiResponseFaild('Unauthorized', 'You do not have permission to create notifications', 403);
        }

        if (isset($request->user_id)){
            $user=User::query()->where('id',$request->id)->first();
            if ($user->role=='agency'){
                $notifiableType='App\Models\Agency';
            }
            elseif ($user->role=='user'){
                $notifiableType='App\Models\User';

            }
            $notifiableId=$user->id;
        }
        try {
            $notification = Notification::create([
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
                'notifiable_type'=>$notifiableType??null,
                'notifiable_id'=>$notifiableId??null,
            ]);

            return $this->ApiResponseSuccessInsert();
        } catch (\Exception $e) {
            return $this->ApiResponseFaild('Failed to create notification', $e->getMessage(), 500);
        }
    }



}
