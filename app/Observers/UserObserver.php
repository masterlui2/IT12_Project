<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Technician;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        switch ($user->role) {
            case 'Customer':
                Customer::create(['user_id' => $user->id]);
                break;
            case 'technician':
                Technician::create(['user_id' => $user->id]);
                break;
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
