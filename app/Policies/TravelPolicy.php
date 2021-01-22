<?php

namespace App\Policies;

use App\User;
use App\Travel;
use Illuminate\Auth\Access\HandlesAuthorization;

class TravelPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Travel $travel)
    {
        return $user->is($travel->owner);
    }    
}
