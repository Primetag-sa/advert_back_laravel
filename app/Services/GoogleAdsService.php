<?php

namespace App\Services;

use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V18\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\V18\Services\ListAccessibleCustomersRequest;
use Illuminate\Support\Facades\Auth;
use Google\Ads\GoogleAds\V18\Services\SearchGoogleAdsRequest;

class GoogleAdsService
{
    protected $client;

    public function getClientForUser()
    {
        $user = Auth::user();

        if (! $user->google_token) {
            throw new \Exception('No Google Ads token found for user');
        }

        try {
            $oAuth2Credential = (new OAuth2TokenBuilder)
                ->withClientId(env('GOOGLE_ADS_CLIENT_ID'))
                ->withClientSecret(env('GOOGLE_ADS_CLIENT_SECRET'))
                ->withRefreshToken($user->google_refresh_token)
                ->build();

            $client = (new GoogleAdsClientBuilder)
                ->withOAuth2Credential($oAuth2Credential)
                ->withDeveloperToken(env('GOOGLE_DEVELOPER_TOKEN'))
                ->build();

            if ($client === null) {
                throw new \Exception('GoogleAdsClient is null');
            }

            return $client;
        } catch (\Exception $e) {
            throw new \Exception('Error initializing Google Ads Client: '.$e->getMessage());
        }
    }

    public function getAllCustomers()
    {
        $client = $this->getClientForUser();

        $customerServiceClient = $client->getCustomerServiceClient();
        $request = new ListAccessibleCustomersRequest();
        $response = $customerServiceClient->listAccessibleCustomers($request);

        return $this->processCustomers($response);
    }

    public function getCustomerCampaigns($customerId)
    {

        $client = $this->getClientForUser();

        $googleAdsService = $client->getGoogleAdsServiceClient();

        $query = "SELECT campaign.id, campaign.name
                  FROM campaign
                  WHERE campaign.status = 'ENABLED'";


        $request = new SearchGoogleAdsRequest([
            'customer_id' => $customerId,
            'query' => $query,
        ]);


        $response = $googleAdsService->search($request);

        return $this->processCampaigns($response);
    }

    public function getCampaignAdGroups($customerId, $campaignId)
    {
        $googleAdsService = $this->client->getGoogleAdsServiceClient();

        $query = "SELECT ad_group.id, ad_group.name, metrics.impressions, metrics.clicks
                  FROM ad_group
                  WHERE ad_group.campaign.id = {$campaignId}";

        $response = $googleAdsService->search($customerId, $query);

        return $this->processAdGroups($response);
    }

    public function getAdGroupAds($customerId, $adGroupId)
    {
        $googleAdsService = $this->client->getGoogleAdsServiceClient();

        $query = "SELECT ad.id, ad.type, metrics.impressions, metrics.clicks
                  FROM ad
                  WHERE ad.ad_group.id = {$adGroupId}";

        $response = $googleAdsService->search($customerId, $query);

        return $this->processAds($response);
    }

    public function getMetricsForEntity($entityType, $entityId)
    {
        switch ($entityType) {
            case 'customer':
                return $this->getCustomerMetrics($entityId);
            case 'campaign':
                return $this->getCampaignMetrics($entityId);
            case 'ad_group':
                return $this->getAdGroupMetrics($entityId);
            case 'ad':
                return $this->getAdMetrics($entityId);
            default:
                throw new \Exception("Unsupported entity type");
        }
    }

    public function searchEntities($filters)
    {
        // Implémentation de recherche dynamique basée sur des filtres
        // Cela peut nécessiter la construction de requêtes dynamiques.
        throw new \Exception('searchEntities method not implemented yet.');
    }

    private function processCustomers($customers)
    {

        $processed = [];
        foreach ($customers->getResourceNames() as $resourceName) {
            $processed[] = [
                'resourceName' => $resourceName,
                'customerId' => substr($resourceName, 10) // Extrait uniquement l'ID du client
            ];
        }
        return $processed;
    }

    private function processCampaigns($campaigns)
    {
        $processed = [];
        foreach ($campaigns->iterateAllElements() as $campaign) {
            $processed[] = [
                'id' => $campaign->getCampaign()->getId(),
                'name' => $campaign->getCampaign()->getName(),
                'impressions' => $campaign->getMetrics()->getImpressions(),
                'clicks' => $campaign->getMetrics()->getClicks(),
            ];
        }
        return $processed;
    }

    private function processAdGroups($adGroups)
    {
        $processed = [];
        foreach ($adGroups->iterateAllElements() as $adGroup) {
            $processed[] = [
                'id' => $adGroup->getAdGroup()->getId(),
                'name' => $adGroup->getAdGroup()->getName(),
                'impressions' => $adGroup->getMetrics()->getImpressions(),
                'clicks' => $adGroup->getMetrics()->getClicks(),
            ];
        }
        return $processed;
    }

    private function processAds($ads)
    {
        $processed = [];
        foreach ($ads->iterateAllElements() as $ad) {
            $processed[] = [
                'id' => $ad->getAd()->getId(),
                'type' => $ad->getAd()->getType(),
                'impressions' => $ad->getMetrics()->getImpressions(),
                'clicks' => $ad->getMetrics()->getClicks(),
            ];
        }
        return $processed;
    }

    private function getCustomerMetrics($customerId)
    {
        // Implémentation pour récupérer les métriques des customers
        throw new \Exception('getCustomerMetrics method not implemented yet.');
    }

    private function getCampaignMetrics($campaignId)
    {
        // Implémentation pour récupérer les métriques des campagnes
        throw new \Exception('getCampaignMetrics method not implemented yet.');
    }

    private function getAdGroupMetrics($adGroupId)
    {
        // Implémentation pour récupérer les métriques des groupes d'annonces
        throw new \Exception('getAdGroupMetrics method not implemented yet.');
    }

    private function getAdMetrics($adId)
    {
        // Implémentation pour récupérer les métriques des annonces
        throw new \Exception('getAdMetrics method not implemented yet.');
    }
}
