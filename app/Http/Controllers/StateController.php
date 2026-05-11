<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    /**
     * Display listing of states
     */
    public function index()
    {
        $states = State::with('tribes', 'products')->get();

        return inertia('States/Index', [
            'states' => $states,
        ]);
    }

    /**
     * Display single state with tribes and products
     */
    public function show(State $state)
    {
        $state->load(['tribes.products.images', 'products.images']);

        return inertia('States/Show', [
            'state' => $state,
        ]);
    }
}
