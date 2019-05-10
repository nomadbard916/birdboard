<?php

// namespace App\Policies;
namespace tests\Feature\ProjectsTest;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest
{
 use HandlesAuthorization;

 use WithFaker, RefreshDatabase;

 /**
  * Create a new policy instance.
  *
  * @return void
  */
 public function __construct()
 {
  //
 }

 public function aUserCanCreateAProject()
 {
  $attributes = [
   'title'       => $this->faker->sentence,
   'description' => $this->faker->paragraph,
  ];

  $this->post('/projects', $attributes);

  $this->assertDatabaseHas('projects', $attributes);
 }
}