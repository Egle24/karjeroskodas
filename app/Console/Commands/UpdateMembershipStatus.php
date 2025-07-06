<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Memberships;

class UpdateMembershipStatus extends Command
{
    protected $signature = 'membership:update-status';
    protected $description = 'Update membership status based on subscription end date';

    public function handle()
    {
        // Update all memberships where subscription has expired
        Memberships::where('subscription_end_date', '<', now())
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $this->info('Membership statuses updated successfully.');
    }
}
