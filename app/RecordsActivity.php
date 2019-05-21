<?php

namespace App;

trait RecordsActivity
{
    public $oldAttributes = [];

    public static function bootRecordsActivity()
    {

        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {

                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                /**
                 * As the original updating in observer uses updating(Project $project),
                 * we can just abstract the callback variable to $model
                 */

                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription($description)
    {

        return "{$description}_" . \strtolower(\class_basename($this)); // eg. created_task

    }

    protected static function recordableEvents()
    {

        if (isset(static::$recordableEvents)) {

            return static::$recordableEvents;
        }

        return ['created', 'updated'];

    }

    public function recordActivity($description)
    {
        $this->activity()->create([

            'description' => $description,
            'changes'     => $this->activityChanges(),
            'project_id'  => \class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'user_id'     => ($this->project ?? $this)->owner->id, // Project itself is able to return owner directly, while other classes needs to do this indirectly by calling to belonging project first, therefore there's needs a conditional statement.
        ]);

        // Activity::create([
        //     'project_id'  => $this->id,
        //     'description' => $type,
        // ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
        // add latest() to make it always ascending order
    }

    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after'  => array_except($this->getChanges(), 'updated_at'),
            ];
        }

    }
}