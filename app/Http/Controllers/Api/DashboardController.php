<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Trait\ApiResponseTrait;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    public function getDashboard(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->apiResponseFaild('Unauthorized', 'User not authenticated', 401);
        }

        switch ($user->role) {
            case 'admin':
                $data = $this->getAdminDashboard();
                break;

            case 'agency':
                $data = $this->getAgencyDashboard();
                break;

            case 'user':
                $data = $this->getUserDashboard();
                break;

            default:
                return $this->apiResponseFaild('Unauthorized', 'Invalid role', 403);
        }

        return $this->apiResponseSuccess($data, 'Dashboard data fetched successfully');
    }

    private function getAdminDashboard()
    {
        $agencies = Agency::paginate(10);
        return [
            'title' => 'Admin Dashboard',
            'agencies' => $agencies,
        ];
    }


    private function getAgencyDashboard()
    {
        $authUser = Auth::user();

        $users = User::where('created_by_id', $authUser->id)->paginate(10);
        return [
            'title' => 'Agency Dashboard',
            'users' => $users,
        ];
    }


    private function getUserDashboard()
    {
        return [
            'title' => 'User Dashboard',
            'visitors' => [
                'facebook' => 123,
                'snapchat' => 56,
                'tiktok' => 910,
                'instagram' => 1213,
            ],
        ];
    }

}
