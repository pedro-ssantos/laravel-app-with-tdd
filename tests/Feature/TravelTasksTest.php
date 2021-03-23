<?php

namespace Tests\Feature;

use App\Travel;
use Facades\Tests\Setup\TravelFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TravelTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_travels()
    {
        $travel = factory('App\Travel')->create();

        $this->post($travel->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    function only_the_owner_of_a_travel_may_add_tasks()
    {
        $this->signIn();

        $travel = factory('App\Travel')->create();

        $this->post($travel->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function only_the_owner_of_a_travel_may_update_a_task()
    {
        $this->signIn();

        $travel = TravelFactory::withTasks(1)->create();

        $this->patch($travel->tasks[0]->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    public function a_travel_can_have_tasks()
    {
        $travel = TravelFactory::create();

        $this->actingAs($travel->owner)
        ->post($travel->path() . '/tasks', ['body' => 'Test task']);

        $this->get($travel->path())
            ->assertSee('Test task');
    }

    /** @test */
    function a_task_can_be_updated()
    {
        $travel = TravelFactory::withTasks(1)->create();

        $this->actingAs($travel->owner)
        ->patch($travel->tasks[0]->path(), [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
        ]);
    }

    /** @test */
    function a_task_can_be_completed()
    {
        $travel = TravelFactory::withTasks(1)->create();

        $this->actingAs($travel->owner)
        ->patch($travel->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    function a_task_can_be_marked_as_incompleted()
    {
        $this->withoutExceptionHandling();

        $travel = TravelFactory::withTasks(1)->create();

        $this->actingAs($travel->owner)
        ->patch($travel->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($travel->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $travel = TravelFactory::create();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->actingAs($travel->owner)
        ->post($travel->path() . '/tasks', $attributes)
        ->assertSessionHasErrors('body');
    }
}
