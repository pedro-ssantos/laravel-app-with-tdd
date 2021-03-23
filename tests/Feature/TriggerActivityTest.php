<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\TravelFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */

     function creating_a_travel()
     {
         $this->withoutExceptionHandling();

         $travel = TravelFactory::create();

         $this->assertCount(1, $travel->activity);
         $this->assertEquals('created', $travel->activity[0]->description);
     }

     /**
      * @test
      */
     function updating_a_travel()
     {
        $travel = TravelFactory::create();

        $travel->update(['title' => 'Changed']);

        $this->assertCount(2, $travel->activity);
        $this->assertEquals('updated', $travel->activity->last()->description);

     }

     /**
      * @test
      */

      function creating_a_new_task()
      {
        $travel = TravelFactory::create();

        $travel->addTask('some task');

        $this->assertCount(2, $travel->activity);

        tap($travel->activity->last(), function ($activity) {
          $this->assertEquals('created_task', $travel->activity->last()->description);
          $this->assertInstanceOf(Task::class, $activity->subject);
          $this->assertEquals('Some task', $activity->subject->body);
        });

      }
    /**
      * @test
      */

      function completing_a_task()
      {
        $travel = TravelFactory::withTasks(1)->create();

        $this->actingAs($travel->owner)
            ->patch($travel->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
        ]);

        $this->assertCount(3, $travel->activity);

        tap($travel->activity->last(), function ($activity) {
          $this->assertEquals('completed_task', $travel->activity->last()->description);
          $this->assertInstanceOf(Task::class, $activity->subject);
        });

      }

      /**
       * @test
       */
      function incompleting_a_task()
      {
        $travel = TravelFactory::withTasks(1)->create();

        $this->actingAs($travel->owner)
        ->patch($travel->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $travel->activity);

        $this->actingAs($travel->owner)
        ->patch($travel->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $travel->refresh();

        $this->assertCount(4, $travel->activity);
        $this->assertEquals('incompleted_task', $travel->activity->last()->description);
      }
}
