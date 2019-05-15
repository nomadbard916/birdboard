<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Attributes to guard against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['project'];

    protected static function boot()
    {
        //  override boot() in parent class with our own definition and then call the parent boot()
        parent::boot();

        static::created(function ($task) {
            // Activity::create([
            //     'project_id'  => $task->project->id,
            //     'description' => 'created_task',
            // ]);
            $task->project->recordActivity('created_task');
        });

        // static::updated(function ($task) {
        //     if (!$task->completed) {
        //         return;
        //     }

        // $task->project->recordActivity('completed_task');

        // Activity::create([
        //     'project_id'  => $task->project->id,
        //     'description' => 'completed_task',
        // ]);
        // });

    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->project->recordActivity('completed_task');
    }

    /**
     * Get the owning project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the path to the task.
     *
     * @return string
     */
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}