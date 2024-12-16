<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountsX;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\User;
use App\Services\TikTokService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TiktokController extends Controller
{
    public function getCampains(Request $request, TikTokService $tikTokService)
    {

        $user = Auth::user();

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        // Vérifier si un token utilisateur est présent

        if (! $user) {

            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);

        }

        $campaigns = $tikTokService->getCampaigns($user->tiktok_token, $advertiser_id);

        return json_encode([$campaigns]);
    }

    public function getAdGroup(Request $request, TikTokService $tikTokService)
    {

        $user = Auth::user();

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        $campaigns_id = $request->query('campaign_ids');
        // Vérifier si un token utilisateur est présent

        if (! $user) {

            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);

        }

        $adGroup = $tikTokService->getAdGroup($user->tiktok_token, $advertiser_id, $campaigns_id);

        return json_encode([$adGroup]);
    }

    public function getAd(Request $request, TikTokService $tikTokService)
    {

        $user = Auth::user();

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        $campaigns_id = $request->query('campaign_ids');
        $adGroups_id = $request->query('adgroup_ids');
        // Vérifier si un token utilisateur est présent

        if (! $user) {

            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);

        }

        $adGroup = $tikTokService->getAd($user->tiktok_token, $advertiser_id, $campaigns_id, $adGroups_id);

        return json_encode([$adGroup]);
    }

    public function fetchAndStoreAccounts(Request $request, TikTokService $tikTokService)
    {
        $url = $request->query('url');
        $user = Auth::user();

        if (!$user || !$user->tiktok_token) {
            $redirectUrl = config('app.url_frontend') . $url . '?status=failure';
            return redirect($redirectUrl);
        }

        try {
            // Fetch data from TikTok API
            $data = $tikTokService->getAdvertiserGet($user->tiktok_token);

            // Check if data is valid
            if (empty($data['data']['list'])) {
                return response()->json(['error' => 'No TikTok accounts found'], 404);
            }

            // Save TikTok account data
            $user->tiktok_id = json_encode($data['data']['list']);
            $user->save();

            // Optionally update or create accounts
            /*
            foreach ($data['data']['list'] as $accountData) {
                AccountsX::updateOrCreate(
                    ['account_id' => $accountData['id']],
                    [
                        'name' => $accountData['name'],
                        'business_name' => $accountData['business_name'],
                        'timezone' => $accountData['timezone'],
                        'timezone_switch_at' => $accountData['timezone_switch_at'],
                        'business_id' => $accountData['business_id'],
                        'approval_status' => $accountData['approval_status'],
                        'deleted' => $accountData['deleted'],
                        'user_id' => $user->id,
                    ]
                );
            }
            */

            return response()->json($data, 200);

        } catch (RequestException $e) {
            Log::error('TikTok API Request Failed: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching data'], 402);
        } catch (\Exception $e) {
            Log::error('Unexpected Error: ' . $e->getMessage());
            return response()->json(['error' => 'Unexpected error occurred'], 500);
        }
    }



    public function accounts(Request $request, TikTokService $tikTokService)
    {
        $data=[];

        $url = $request->query('url');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (!$user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        try {
            $agency = Agency::where('user_id', $user->id)->first();

            if ($agency) {
                $agents = User::where('role', 'agent')
                    ->whereHas('agent', function ($q) use ($agency) {
                        $q->where('agency_id', $agency->id);
                    })->get();
            } else {

                $agents = [];
            }

            foreach ($agents as $agent) {
                if ($agent->tiktok_token) {

                    $data[] =[
                        "agent"=>$agent,
                        "account"=>$tikTokService->getAdvertiserGet($agent->tiktok_token),
                        "platform"=>'tiktok'
                    ];
                }
            }
            return response()->json($data, 200);
        } catch (RequestException $e) {
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }
    }

    public function getConversionsPerOneThousandImpressions(Request $request, TikTokService $tikTokService)
    {

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        $data_level = $request->query('data_level');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $other = $request->query('other');
        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user || ! $user->tiktok_token) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        try {

            $data = $tikTokService->getConversionsPerOneThousandImpressions($user->tiktok_token, $advertiser_id, $data_level, $start_date, $end_date, $other);

            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }

    }

    public function getConversionsPerImpressions(Request $request, TikTokService $tikTokService)
    {

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        $data_level = $request->query('data_level');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $other = $request->query('other');
        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user || ! $user->tiktok_token) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        try {

            $data = $tikTokService->getConversionsPerImpressions($user->tiktok_token, $advertiser_id, $data_level, $start_date, $end_date, $other);

            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }

    }

    public function getImpressionsPerAudiance(Request $request, TikTokService $tikTokService)
    {

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        $data_level = $request->query('data_level');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $other = $request->query('other');
        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user || ! $user->tiktok_token) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        try {

            $data = $tikTokService->getImpressionsPerAudiance($user->tiktok_token, $advertiser_id, $data_level, $start_date, $end_date, $other);

            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }

    }

    public function getConversionsPerRevenue(Request $request, TikTokService $tikTokService)
    {

        $url = $request->query('url');
        $advertiser_id = $request->query('advertiser_id');
        $data_level = $request->query('data_level');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $other = $request->query('other');
        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user || ! $user->tiktok_token) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        try {

            $data = $tikTokService->getConversionsPerRevenue($user->tiktok_token, $advertiser_id, $data_level, $start_date, $end_date, $other);

            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }

    }
}
