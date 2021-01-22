<?php

namespace Tests\Setup;

use App\Travel;
use App\Task;
use App\User;

class TravelFactory
{
    protected $tasksCount = 0;
    protected $user;

    public function withTasks($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $travel = factory(Travel::class)->create([
            'owner_id' => $this->user ?? factory(User::class)
        ]);

        factory(Task::class, $this->tasksCount)->create([
            'travel_id' => $travel
        ]);

        return $travel;
    }
}

