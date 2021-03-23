<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TravelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_path()
    {
        $travel = factory('App\Travel')->create();

        $this->assertEquals('/travels/'. $travel->id, $travel->path());
    }

    /**
     * @test
     */
    public function it_belongs_to_an_owner()
    {
        $travel = factory('App\Travel')->create();

        $this->assertInstanceOf('App\User', $travel->owner);
    }

    /**
     * @test
     */
    public function it_can_add_a_task()
    {
        $travel = factory('App\Travel')->create();

        $task = $travel->addTask('Test task');

        $this->assertCount(1, $travel->tasks);
        $this->assertTrue($travel->tasks->contains($task));
    }
}
