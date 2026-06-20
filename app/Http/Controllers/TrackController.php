<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\DifficultyLevel;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tracks = Track::all();
        return view('track.index', compact('tracks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannnot('create', Track::class)) {
            abort(403, 'Unauthorized action.');
        }

        $competitions = Competition::all();
        $difficultyLevels = DifficultyLevel::all();
        return view('track.create', compact('competitions', 'difficultyLevels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Track $track)
    {
        if ($request->user()->cannnot('create', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'name' => 'required|max:20',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        Track::create($validated);
        return redirect()->route('track.index')
            ->with('success', 'Track created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $track = Track::with(['competition', 'difficultyLevel'])->findOrFail($id);

        return view('track.show', compact('track'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , string $id)
    {
        $track = Track::findOrFail($id);

        if ($request->user()->cannnot('update', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $competitions = Competition::all();
        $difficultyLevels = DifficultyLevel::all();
        return view('track.edit', compact('track', 'competitions', 'difficultyLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $track = Track::findOrFail($id);

        if ($request->user()->cannnot('update', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'name' => 'required|max:20',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        $track->update($validated);
        return redirect()->route('track.show', $track->id)
            ->with('success', 'Track updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Track $track)
    {
        if ($request->user()->cannnot('delete', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $track->delete();
        return redirect()->route('track.index')
            ->with('success', 'Track deleted.');
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannnot('viewTrashed', Track::class)) {
            abort(403, 'Unauthorized action.');
        }
        $tracks = Track::onlyTrashed()->get();
        return view('track.trashed', compact('tracks'));
    }

    public function restore(Request $request, string $id)
    {
        $track = Track::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannnot('restore', Track::class)) {
            abort(403, 'Unauthorized action.');
        }
        $track->restore();
        return redirect()->route('track.trashed')
            ->with('success', 'Track restored.');
    }

    public function forceDelete(Request $request, string $id)
    {
        $track = Track::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannnot('forceDelete', Track::class)) {
            abort(403, 'Unauthorized action.');
        }

        $track->forceDelete();
        return redirect()->route('track.trashed')
            ->with('success', 'Track permanently deleted.');
    }
}
