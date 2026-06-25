<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\DifficultyLevel;
use App\Models\Photo;
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
        $tracks = Track::with([
            'competition',
            'difficultyLevel',
            'schemePhotos'])->get();
        return view('track.index', compact('tracks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Track::class)) {
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
        if ($request->user()->cannot('create', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'name' => 'required|max:20',
        ]);

        $track = Track::create([
            'created_by_user_id' => Auth::id(),
            'name' => $validated['name'],
            'competition_id' => $validated['competition_id'],
            'difficulty_level_id' => $validated['difficulty_level_id'],
        ]);

        if ($request->hasFile('scheme_photo')) {
            $this->storeTrackPhoto($request, $track);
        }

        return redirect()->route('track.index')
            ->with('success', __('controllers.new_track'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        $track->load([
            'competition',
            'difficultyLevel',
            'schemePhotos' => function ($query) {
                $query->where('is_approved', true)
                    ->latest();
            },
        ]);

        return view('track.show', compact('track'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , string $id)
    {
        $track = Track::findOrFail($id);

        if ($request->user()->cannot('update', $track)) {
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

        if ($request->user()->cannot('update', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'difficulty_level_id' => 'required|exists:difficulty_levels,id',
            'name' => 'required|max:20',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        $track->update($validated);

        if ($request->has('delete_scheme_photo')) {
            $this->deleteTrackPhotos($track);
        }

        if ($request->hasFile('scheme_photo')) {
            $this->deleteTrackPhotos($track);
            $this->storeTrackPhoto($request, $track);
        }

        return redirect()->route('track.index')
            ->with('success', __('controllers.updated_track'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Track $track)
    {
        if ($request->user()->cannot('delete', $track)) {
            abort(403, 'Unauthorized action.');
        }

        $track->delete();
        return redirect()->route('track.index')
            ->with('success', __('controllers.deleted_track'));
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Track::class)) {
            abort(403, 'Unauthorized action.');
        }
        $tracks = Track::onlyTrashed()->get();
        return view('track.trashed', compact('tracks'));
    }

    public function restore(Request $request, string $id)
    {
        $track = Track::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', Track::class)) {
            abort(403, 'Unauthorized action.');
        }
        $track->restore();
        return redirect()->route('track.trashed')
            ->with('success', __('controllers.restored_track'));
    }

    public function forceDelete(Request $request, string $id)
    {
        $track = Track::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', Track::class)) {
            abort(403, 'Unauthorized action.');
        }

        $track->forceDelete();
        return redirect()->route('track.trashed')
            ->with('success', __('controllers.force_deleted_track'));
    }

    private function storeTrackPhoto(Request $request, Track $track): void
    {
        $filePath = $request->file('scheme_photo')->store('gallery', 'public');

        Photo::create([
            'uploaded_by_user_id' => $request->user()->id,
            'competition_id' => $track->competition_id,
            'track_id' => $track->id,
            'pair_id' => null,
            'title' => 'Track ' . $track->name,
            'file_path' => $filePath,
            'is_approved' => true,
        ]);
    }

    private function deleteTrackPhotos(Track $track): void
    {
        Photo::where('track_id', $track->id)
            ->whereNull('deleted_at')
            ->get()
            ->each(function (Photo $photo) {
                $photo->delete();
            });
    }
}
