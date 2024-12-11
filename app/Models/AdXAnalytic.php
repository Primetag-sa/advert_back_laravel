<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdXAnalytic extends Model
{
    protected $fillable = [
        'account_id',
        'data_type',
        'ad_id',
        'time_series_length',
        'start_time',
        'end_time',
        'granularity',
        'data_analytics',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'data' => 'array',
    ];

    public static function storeAnalytics($response, $startTime, $endTime, $granularity,$accountId)
    {
        foreach ($response['data'] as $data) {
            self::create([
                'account_id' => $accountId,
                'data_type' => $response['data_type'],
                'ad_id' => $data['id'],
                'time_series_length' => $response['time_series_length'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'granularity' => $granularity,
                'data_analytics' => $data['id_data'],  // Stocke directement tout le tableau id_data
            ]);
        }
    }

    // Obtenir tous les segments
    public function getSegments()
    {
        return $this->data_analytics;
    }

    // Obtenir les métriques pour un segment spécifique
    public function getMetricsForSegment($segmentIndex = 0)
    {
        return $this->data_analytics[$segmentIndex]['metrics'] ?? null;
    }

    // Obtenir une métrique spécifique pour un segment
    public function getMetricValues($metricName, $segmentIndex = 0)
    {
        return $this->data_analytics[$segmentIndex]['metrics'][$metricName] ?? null;
    }
    public function scopeForAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }
    // Obtenir les données du segment
    public function getSegmentData($segmentIndex = 0)
    {
        return $this->data_analytics[$segmentIndex]['segment'] ?? null;
    }
    public function scopeForAd($query, $adId)
    {
        return $query->where('ad_id', $adId);
    }
}
