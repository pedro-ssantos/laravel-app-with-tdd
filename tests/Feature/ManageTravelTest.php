<?php

namespace Tests\Feature;

use App\Travel;
use Facades\Tests\Setup\TravelFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageTravelTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guest_cannot_manage_travels()
    {
        $travel = factory('App\Travel')->create();

        $this->get('/travels')->assertRedirect('login');
        $this->get('/travels/create')->assertRedirect('login');
        $this->post('/travels')->assertRedirect('login');
        $this->get($travel->path().'/edit')->assertRedirect('login');
        $this->get($travel->path(), $travel->toArray())->assertRedirect('login');
    }

    /**
     * @test 
     * */
    public function a_user_can_create_a_travel()
    {
        $this->signIn();

        $this->get('/travels/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/travels', $attributes);

        $travel = Travel::where($attributes)->first();

        $response->assertRedirect($travel->path());

        $this->get($travel->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

     /**
      *  @test */
     function a_user_can_update_a_travel()
     {
        $this->withoutExceptionHandling();

       $travel = TravelFactory::create();

       $this->actingAs($travel->owner)->get($travel->path().'/edit')->assertOk();

 
        $this->actingAs($travel->owner)
        ->patch($travel->path(), $attributes = [
            'title' => "Changed",
            'description' => 'Changed',
            'notes' => 'Changed'
        ])->assertRedirect($travel->path());
            

        $this->assertDatabaseHas('travels', $attributes);
     }

     /**
      * @test
      */

      function a_user_can_update_a_travels_notes()
      {
          $travel = TravelFactory::create();

          $this->actingAs($travel->owner)
          ->patch($travel->path(), $attributes = ['notes' => 'Changed']);

          $this->assertDatabaseHas('travels', $attributes);
      }

     /**
      * @test
      */
      public function a_user_can_view_their_travel()
      {
          $travel = TravelFactory::create();

          $this->actingAs($travel->owner)
          ->get($travel->path())
          ->assertSee($travel->title)
          ->assertSee($travel->description);
      }

     /**
      * @test
      */

      public function an_authenticated_user_cannot_update_the_travels_of_others()
      {
          $this->signIn();
          $travel = factory('App\Travel')->create();

          $this->patch($travel->path())->assertStatus(403);
      }

    /**
     * @test
      */
    public function an_authenticated_user_cannot_view_the_travels_of_others()
    {
        $this->signIn();
        $travel = factory('App\Travel')->create();
        $this->get($travel->path())->assertStatus(403);
    }

    /**
     * @test */
    public function a_travel_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Travel')->raw(['description' => '']);
        $this->post('/travels', $attributes)->assertSessionHasErrors('description');
    }
}
