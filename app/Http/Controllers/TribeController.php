<?php

namespace App\Http\Controllers;

use App\Models\Tribe;

class TribeController extends Controller
{
    /**
     * Display listing of tribes
     */
    public function index()
    {
        $tribes = Tribe::with('state', 'products')->get();

        return inertia('Tribes/Index', [
            'tribes' => $tribes,
        ]);
    }

    /**
     * Display single tribe with products
     */
    public function show(Tribe $tribe)
    {
        $tribe->load(['state', 'products.images']);

        return inertia('Tribes/Show', [
            'tribe' => $tribe,
        ]);
    }
}
