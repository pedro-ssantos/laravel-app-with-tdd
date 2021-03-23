<?php

namespace App\Observers;

use App\Activity;
use App\Travel;

class TravelObserver
{
    public function created(Travel $travel)
    {
        $travel->recordActivity('created');
    }

    public function updated(Travel $travel)
    {
        $travel->recordActivity('updated');
    }

    
}
