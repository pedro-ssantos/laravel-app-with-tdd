<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded =[];

    protected $touchs = ['travel'];

    protected function travel()
    {
        return $this->belongsTo(Travel::class);
    }

    public function path()
    {
        return "/travels/{$this->travel->id}/tasks/{$this->id}";
    }
}
