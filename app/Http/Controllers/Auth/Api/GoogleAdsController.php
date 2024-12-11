<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Services\GoogleAdsService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAdsController extends Controller
{
    protected $googleAdsService;

    public function __construct(GoogleAdsService $googleAdsService)
    {
        $this->googleAdsService = $googleAdsService;
    }

    // Récupération de tous les customers
    public function getCustomers()
    {
        $user = Auth::user();

        try {

            $customers = $this->googleAdsService->getAllCustomers();
            $user->customers_google = json_encode($customers);
            $user->save();

            return response()->json([
                'status' => 'success',
                'data' => $customers,
            ]);
        } catch (RequestException $e) {
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);

        }
    }

    // Récupération des campagnes pour un customer
    public function getCampaigns($customerId)
    {
        try {
            $campaigns = $this->googleAdsService->getCustomerCampaigns($customerId);

            return response()->json([
                'status' => 'success',
                'data' => $campaigns,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Récupération des ad groups pour une campagne
    public function getAdGroups($customerId, $campaignId)
    {
        try {
            $adGroups = $this->googleAdsService->getCampaignAdGroups($customerId, $campaignId);

            return response()->json([
                'status' => 'success',
                'data' => $adGroups,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Récupération des ads pour un ad group
    public function getAds($customerId, $adGroupId)
    {
        try {
            $ads = $this->googleAdsService->getAdGroupAds($customerId, $adGroupId);

            return response()->json([
                'status' => 'success',
                'data' => $ads,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Récupération des métriques pour une entité spécifique
    public function getEntityMetrics($entityType, $entityId)
    {
        try {
            $metrics = $this->googleAdsService->getMetricsForEntity($entityType, $entityId);

            return response()->json([
                'status' => 'success',
                'data' => $metrics,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Filtrage et recherche
    public function searchEntities(Request $request)
    {
        try {
            $filters = $request->all();
            $results = $this->googleAdsService->searchEntities($filters);

            return response()->json([
                'status' => 'success',
                'data' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
