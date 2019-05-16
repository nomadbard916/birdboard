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
        return $this->hasMany(Activity::class);
    }

    public function recordActivity($description)
    {
        $this->activity()->create(compact('description'));

        // Activity::create([
        //     'project_id'  => $this->id,
        //     'description' => $type,
        // ]);
    }
}