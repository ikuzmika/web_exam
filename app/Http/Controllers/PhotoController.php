<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Pair;
use App\Models\Photo;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
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
        $photos = Photo::with([
            'uploadedBy',
            'competition',
            'pair.dog.handler',
            'track.competition',
            'track.difficultyLevel'
        ])->where('is_approved', true)
            ->whereNull('track_id')
            ->latest()->paginate(5);

        return view('photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Photo::class)) {
            abort(403, 'Unauthorized action.');
        }

        $competitions = Competition::orderByDesc('date')->get();
        $pairs = Pair::with(['dog.handler'])->orderBy('id')->get();
        $tracks = Track::with(['competition', 'difficultyLevel'])
            ->orderBy('competition_id')->orderBy('id')->get();

        return view('photos.create', compact('competitions', 'pairs', 'tracks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Photo $photo)
    {
        if ($request->user()->cannot('create', Photo::class)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'nullable|integer|exists:competitions,id',
            'pair_id' => 'nullable|integer|exists:pairs,id',
            'track_id' => 'nullable|integer|exists:tracks,id',
            'title' => 'nullable|string|max:200',
            'photo' => 'required|file|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $filePath = $request->file('photo')->store('gallery', 'public');

        Photo::create([
            'uploaded_by_user_id' => Auth::id(),
            'competition_id' => $validated['competition_id'] ?? null,
            'pair_id' => $validated['pair_id'] ?? null,
            'track_id' => $validated['track_id'] ?? null,
            'title' => $validated['title'] ?? null,
            'file_path' => $filePath,
            'is_approved' => $request->user()->isAdmin()
        ]);

        return redirect()->route('photo.index')
            ->with('success', __('controllers.new_photo'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        if ($photo->track_id) {
            return redirect()->route('track.show', $photo->track_id);
        }

        $photo->load([
            'uploadedBy',
            'competition',
            'pair.dog.handler',
        ]);

        return view('photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Photo $photo)
    {
        if ($request->user()->cannot('update', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $competitions = Competition::orderByDesc('date')->get();
        $pairs = Pair::with('dog.handler')
            ->orderBy('id')->get();
        $tracks = Track::with(['competition', 'difficultyLevel'])
            ->orderBy('competition_id')->orderBy('id')->get();
        return view('photos.edit', compact('competitions', 'pairs', 'photo', 'tracks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        if ($request->user()->cannot('update', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'nullable|integer|exists:competitions,id',
            'pair_id' => 'nullable|integer|exists:pairs,id',
            'track_id' => 'nullable|integer|exists:tracks,id',
            'title' => 'nullable|string|max:200',
            'photo' => 'file|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $filePath = $photo->file_path;

        if ($request->hasFile('file_path')) {
            if ($photo->file_path) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $filePath = $request->file('photo')->store('gallery', 'public');
        }

        $photo->update([
            'competition_id' => $validated['competition_id'] ?? null,
            'pair_id' => $validated['pair_id'] ?? null,
            'track_id' => $validated['track_id'] ?? null,
            'title' => $validated['title'] ?? null,
            'file_path' => $filePath,
            'is_approved' => $request->user()->isAdmin()
        ]);

        return redirect()->route('photo.index', $photo->id)
            ->with('success', __('controllers.updated_photo'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Photo $photo)
    {
        if ($request->user()->cannot('delete', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $photo->delete();
        return redirect()->route('photo.index')
            ->with('success', __('controllers.deleted_photo'));
    }

    public function pending(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $photos = Photo::with([
            'uploadedBy',
            'competition',
            'pair.dog.handler'
        ])->where('is_approved', false)->latest()->paginate(5);

        return view('photos.pending', compact('photos'));
    }

    public function approve(Request $request, Photo $photo)
    {
        if (!$request->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $photo->update([
            'is_approved' => true
        ]);
        return redirect()->route('photo.pending')
            ->with('success', __('controllers.approved_photo'));
    }

    public function reject(Request $request, Photo $photo)
    {
        if (!$request->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $photo->delete();

        return redirect()->route('photo.pending')
            ->with('success', __('controllers.rejected_photo'));
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Photo::class)) {
            abort(403, 'Unauthorized action.');
        }

        $photos = Photo::onlyTrashed()->with([
            'uploadedBy',
            'competition',
            'pair.dog.handler',
            'track.competition',
            'track.difficultyLevel'
        ])->latest()->paginate(5);

        return view('photos.trashed', compact('photos'));
    }

    public function restore(Request $request, string $id)
    {
        $photo = Photo::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $photo->restore();
        return redirect()->route('photo.trashed')
            ->with('success', __('controllers.restored_photo'));
    }

    public function forceDelete(Request $request, string $id)
    {
        $photo = Photo::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        if ($photo->file_path){
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->forceDelete();
        return redirect()->route('photo.trashed')
            ->with('success', __('controllers.force_deleted_photo'));
    }
}
