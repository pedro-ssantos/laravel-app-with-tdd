<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Travel;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_belongs_to_a_travel()
    {
        $task = factory('App\Task')->create();

        $this->assertInstanceOf(Travel::class, $task->travel);
    }

    /**
     * @test
     */
    public function it_has_path()
    {
      $task = factory('App\Task')->create();

      $this->assertEquals("/travels/{$task->travel->id}/tasks/{$task->id}", $task->path());
    }

    /**
     * @test
     */
    public function it_can_be_completed()
    {
        $task = factory('App\Task')->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

        /**
     * @test
     */
    public function it_can_be_maked_as_incompleted()
    {
        $task = factory('App\Task')->create(['completed' => true]);

        $this->assertTrue($task->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
