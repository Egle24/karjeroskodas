<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignDefaultRoleCommand extends Command
{
    protected $signature = 'role:assign-default';

    protected $description = 'Assign default role to users without roles';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the default role or create it if it doesn't exist
        $defaultRole = Role::firstOrCreate(['name' => 'member']);

        // Get users without any roles assigned
        $usersWithoutRoles = User::doesntHave('roles')->get();

        // Assign the default role to users without roles
        foreach ($usersWithoutRoles as $user) {
            $user->assignRole($defaultRole);
            $this->info("Assigned default role 'member' to user with ID {$user->id}");
        }

        $this->info('Default roles assigned successfully.');
    }
}
