<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

    /**
     * Attributes to guard against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected static $recordableEvents = ['created', 'deleted'];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['project'];

    // protected static function boot()
    // {
    //  override boot() in parent class with our own definition and then call the parent boot()
    // parent::boot();

    // for educational purpose only; it's better practice to use observer
    // static::created(function ($task) {
    //     // Activity::create([
    //     //     'project_id'  => $task->project->id,
    //     //     'description' => 'created_task',
    //     // ]);
    //     $task->project->recordActivity('created_task');
    // });

    // static::deleted(function ($task) {
    //     $task->project->recordActivity('deleted_task');
    // });

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

    // }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');

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

    public function addTask($body)
    {

        // Activity::create([
        //     'project_id'  => $this->id,
        //     'description' => 'created_task',
        // ]);

        return $this->tasks()->create(compact('body'));
    }

}