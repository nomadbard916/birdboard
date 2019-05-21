<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_project_can_invite_a_uer()
    {
        // Given I have a project
        $project = ProjectFactory::create();

        // And the owner of the project invites another user
        $newUser = factory(User::class)->create();

        $project->owner->invite($newUser);
        // Then, that new user will have permission to add tasks
        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);

    }

}