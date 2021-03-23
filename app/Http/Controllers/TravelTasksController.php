<?php

namespace App\Http\Controllers;

use App\Travel;
use App\Task;

class TravelTasksController extends Controller
{
    /**
     * Add a task to the given travel.
     *
     * @param Travel $travel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Travel $travel)
    {
        $this->authorize('update', $travel);

        request()->validate(['body' => 'required']);

        $travel->addTask(request('body'));

        return redirect($travel->path());
    }

    /**
     * Update the travel.
     *
     * @param  Travel $travel
     * @param  Task    $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Travel $travel, Task $task)
    {
        $this->authorize('update', $travel);

        $task->update(request()->validate(['body' => 'required']));

        $method = request('completed') ? $task->complete() :  $task->incomplete();
        
        return redirect($travel->path());
    }
}
