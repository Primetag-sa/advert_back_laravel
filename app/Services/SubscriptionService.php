<?php

namespace App\Services;

class SubscriptionService
{
    public function subscribe($user, $planId)
    {
        return $user->newPlanSubscription('main', $planId);
    }

}
