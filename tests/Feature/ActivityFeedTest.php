<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Setup\ProjectFactory;

class ActivityFeedTest extends TestCase
{
    /** @test */
    public function creating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

    }

}
