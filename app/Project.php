<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use RecordsActivity;

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
        // For Project only. Other models use morphMany() version
        // The Project@activity() overrides trait's activity()
        // meanwhile, trait's function overrides parent class' function
        return $this->hasMany(Activity::class)->latest();
        // add latest() to make it always ascending order
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        // is it true a project can have many members?
        // and also a member can have many projects
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

}