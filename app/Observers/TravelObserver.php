<?php

namespace App\Observers;

use App\Activity;
use App\Travel;

class TravelObserver
{
    public function created(Travel $travel)
    {
        $this->recordActivity($travel, 'created');
    }

    public function updated(Travel $travel)
    {
        $this->recordActivity($travel, 'updated');
    }

    protected function recordActivity($travel, $type)
    {
        Activity::create([
            'travel_id' => $travel->id,
            'description' => $type
        ]);
    }
}
