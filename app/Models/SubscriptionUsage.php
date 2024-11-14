<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubscriptionUsage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subscription_id',
        'feature_id',
        'used',
        'valid_until',
    ];

    protected $casts = [
        'used' => 'integer',
        'valid_until' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    ////////////////////////////////////// Accessors ///////////////////////////
    public function getTable(): string
    {
        return 'subscription_usage';
    }

    ////////////////////////////////////// Relations ///////////////////////////
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class, 'feature_id', 'id', 'feature');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id', 'subscription');
    }

    ////////////////////////////////////// Scopes ///////////////////////////
    public function scopeByFeatureSlug(Builder $builder, string $featureSlug): Builder
    {
        $model = Feature::class;
        $feature = $model::where('slug', $featureSlug)->first();

        return $builder->where('feature_id', $feature ? $feature->getKey() : null);
    }

    ////////////////////////////////////// Functions ///////////////////////////
    public function expired(): bool
    {
        if (! $this->valid_until) {
            return false;
        }

        return Carbon::now()->gte($this->valid_until);
    }
}
