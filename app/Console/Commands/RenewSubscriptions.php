<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;

class RenewSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renew-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew Subscriptions Which ends today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscription::whereDate('ends_at', today())->get();
        $subscriptionService = new SubscriptionService();
        foreach($subscriptions as $subscription){
            $subscriptionService->renewSubscription($subscription);
        }
    }
}
