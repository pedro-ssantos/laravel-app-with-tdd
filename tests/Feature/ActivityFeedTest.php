<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\TravelFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */

     function creatin_a_travel_generates_activity()
     {
         $this->withoutExceptionHandling();

         $travel = TravelFactory::create();

         $this->assertCount(1, $travel->activity);
         $this->assertEquals('created', $travel->activity[0]->description);
     }

     function updating_a_travel_generates_activity()
     {
        $travel = TravelFactory::create();

        $travel->update(['title' => 'Changed']);

        $this->assertCount(2, $travel->activity);
        $this->assertEquals('updated', $travel->activity->last()->description);

     }


}
