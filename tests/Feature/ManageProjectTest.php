<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guest_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get($project->path(), $project->toArray())->assertRedirect('login');
    }

    /**
     * @test 
     * */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

     /**
      *  @test */
     function a_user_can_update_a_project()
     {
        $this->withoutExceptionHandling();

       $project = ProjectFactory::create();

       $this->get($project->path().'/edit')->assertOk();

 
        $this->actingAs($project->owner)
        ->patch($project->path(), $attributes = [
            'title' => "Changed",
            'description' => 'Changed',
            'notes' => 'Changed'
        ])->assertRedirect($project->path());
            

        $this->assertDatabaseHas('projects', $attributes);
     }

     /**
      * @test
      */
      public function a_user_can_view_their_project()
      {
          $project = ProjectFactory::create();

          $this->actingAs($project->owner)
          ->get($project->path())
          ->assertSee($project->title)
          ->assertSee($project->description);
      }

     /**
      * @test
      */

      public function an_authenticated_user_cannot_update_the_projects_of_others()
      {
          $this->signIn();
          $project = factory('App\Project')->create();

          $this->patch($project->path())->assertStatus(403);
      }

    /**
     * @test
      */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
