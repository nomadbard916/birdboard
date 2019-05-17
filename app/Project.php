<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     * Attributes to guard against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    public $old = [];

    /**
     *  The path to the project.
     *
     * @return string
     */
    public function path()
    {
        return "/projects/{$this->id}";
    }

    /**
     * The owner of the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The tasks associated with the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Add a task to the project.
     *
     * @param  string $body
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addTask($body)
    {

        // Activity::create([
        //     'project_id'  => $this->id,
        //     'description' => 'created_task',
        // ]);

        return $this->tasks()->create(compact('body'));
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
        // add latest() to make it always ascending order
    }

    public function recordActivity($description)
    {
        $this->activity()->create([

            'description' => $description,
            'changes'     => $this->activityChanges($description),
        ]);

        // Activity::create([
        //     'project_id'  => $this->id,
        //     'description' => $type,
        // ]);
    }

    protected function activityChanges($description)
    {
        if ($description == 'updated') {
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after'  => array_except($this->getChanges(), 'updated_at'),
            ];
        }

    }
}
