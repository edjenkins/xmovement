<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Artisan;

class UserTest extends TestCase
{
    // use DatabaseMigrations;

    // public function testRegistration()
    // {
    //
    //   // Click to register
    //   $this
    //     ->visit('/')
    //     ->click('Register')
    //     ->seePageIs('/register');
    //
    //   // Fill out registration form
    //   $this
    //     ->type('Test User', 'name')
    //     ->type('test@edjenkins.co.uk', 'email')
    //     ->type('password123', 'password')
    //     ->type('password123', 'password_confirmation')
    //     ->press('Register')
    //     ->seePageIs('/details');
    //
    //   // Add bio to profile
    //   $this
    //     ->type('This is a test account', 'bio')
    //     ->press('Update')
    //     ->seePageIs('/');
    //
    //   // Check it is in database
    //   $this
    //     ->seeInDatabase('users', ['email' => 'test@edjenkins.co.uk']);
    // }

    public function testCreateIdea()
    {
      // Create user
      $user = factory(App\User::class)->create();

      // Create idea with user
      $idea = factory(App\Idea::class)->create([
        'user_id' => $user->id,
      ]);

      // Check idea exists
      $this->seeInDatabase('ideas', ['name' => $idea->name]);
    }

    public function testSupportIdea()
    {
      // Create user (to be used as a supporter)
      $supporter = factory(App\User::class)->create([
        'name' => 'Supporter'
      ]);

      // Create a user (to be associated with the idea)
      $user = factory(App\User::class)->create();

      // Create an idea
      $idea = factory(App\Idea::class)->create([
        'user_id' => $user->id,
      ]);

      DynamicConfig::updateConfig('PROCESS_START_DATE', strtotime("now"), 'timestamp');

      // Update Idea states
  		Artisan::call('update-idea-states');

      // Check that support has the ability to support an idea
      $this->actingAs($supporter)
        ->visit('/idea/' . $idea->id)
        ->see('Support this Idea');

      // Create idea with user
      $support = factory(App\Supporter::class)->create([
        'user_id' => $supporter->id,
        'idea_id' => $idea->id,
      ]);

      $idea->supporters()->save($support);

      // Check it is in database
      $this->seeInDatabase('supporters', [
        'user_id' => $supporter->id,
        'idea_id' => $idea->id,
      ]);

      // Check that support has the ability to support an idea
      $this->actingAs($supporter)
        ->visit('/idea/' . $idea->id)
        ->dontSee('Support this Idea');


    }

    // TODO: For each type of idea progression (fixed / fluid / undefined)

      // TODO: Progression through each phase
      // TODO: Test ability to support
      // TODO: Test ability to add design task
      // TODO: Test ability to contribute to design task
      // TODO: Check idea states



}
