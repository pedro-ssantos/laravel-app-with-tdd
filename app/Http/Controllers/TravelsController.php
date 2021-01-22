<?php

namespace App\Http\Controllers;

use App\Travel;

class TravelsController extends Controller
{
    public function index()
    {
        $travels = auth()->user()->travels;
        return view('travels.index', compact('travels'));
    }

    public function show(Travel $travel)
    {
        $this->authorize('update', $travel);

        return view('travels.show', compact('travel'));
    }

    public function create()
    {
        return view('travels.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);
        
        $travel = auth()->user()->travels()->create($attributes);

        return redirect($travel->path());
    }

    public function edit(Travel $travel)
    {
        return view('travels.edit', compact('travel'));
    }

    public function update(Travel $travel)
    {
        $this->authorize('update', $travel);

        $travel->update($this->validateRequest());

        return redirect($travel->path());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }
}
