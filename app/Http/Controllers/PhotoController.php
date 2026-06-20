<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Pair;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
        $photos = Photo::all();
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

        $competitions = Competition::all();
        $pairs = Pair::all();
        return view('photos.create', compact('competitions', 'pairs'));
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
            'competition_id' => 'required|integer|exists:competitions,id',
            'pair_id' => 'required|integer|exists:pairs,id',
            'title' => 'string|max:200',
            'file_path' => 'required|file|mimes:jpg,jpeg,png|max:255',
        ]);

        $validated['uploded_by_user_id'] = Auth::id();

        Photo::create($validated);

        return redirect()->route('photo.index')
            ->with('success', 'Photo uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $photo = Photo::with(['competition', 'pair'])->findOrFail($id);

        return view('photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $photo = Photo::findOrFail($id);

        if ($request->user()->cannot('update', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $competitions = Competition::all();
        $pairs = Pair::all();
        return view('photos.edit', compact('competitions', 'pairs', 'photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $photo = Photo::findOrFail($id);

        if ($request->user()->cannot('update', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id',
            'pair_id' => 'required|integer|exists:pairs,id',
            'title' => 'string|max:200',
            'file_path' => 'file|mimes:jpg,jpeg,png|max:255',
        ]);

        $validated['uploded_by_user_id'] = Auth::id();

        $photo->update($validated);
        return redirect()->route('photo.show', $photo->id)
            ->with('success', 'Photo updated successfully.');
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
            ->with('success', 'Photo deleted.');
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Photo::class)) {
            abort(403, 'Unauthorized action.');
        }

        $photos = Photo::onlyTrashed()->get();
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
            ->with('success', 'Photo restored.');
    }

    public function forceDelete(Request $request, string $id)
    {
        $photo = Photo::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $photo)) {
            abort(403, 'Unauthorized action.');
        }

        $photo->forceDelete();
        return redirect()->route('photo.trashed')
            ->with('success', 'Photo permanently deleted.');
    }
}
