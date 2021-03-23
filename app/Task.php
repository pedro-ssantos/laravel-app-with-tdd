<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded =[];

    protected $touchs = ['travel'];

    protected $casts = [
        'completed' => 'boolean'
    ];

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

    protected function travel()
    {
        return $this->belongsTo(Travel::class);
    }

    public function path()
    {
        return "/travels/{$this->travel->id}/tasks/{$this->id}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'travel_id' => $this->travel_id,
            'description' => $description
        ]);
    }
}
