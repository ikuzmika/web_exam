<?php

namespace App\Http\Controllers;

use App\Models\Pair;
use App\Models\Result;
use App\Models\ResultStatus;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
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
        $results = Result::all();
        return view('results.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Result::class)) {
            abort(403, 'Unauthorized action.');
        }

        $pairs = Pair::all();
        $tracks = Track::all();
        $result_statuses = ResultStatus::all();
        return view('results.create', compact('pairs', 'tracks', 'result_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Result $result)
    {
        if ($request->user()->cannot('create', $result)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pair_id' => 'required|integer|exists:pairs,id',
            'track_id' => 'required|integer|exists:tracks,id',
            'result_status_id' => 'required|integer|exists:result_statuses,id',
            'points' => 'required|integer'
        ]);

        $validated['recorded_by_user_id'] = Auth::id();

        Result::create($validated);

        return redirect()->route('result.index')
            ->with('success', 'Result created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Result::with(['pair', 'track', 'result_status'])->findOrFail($id);

        return view('results.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $result = Result::findOrFail($id);

        if ($request->user()->cannot('update', $result)) {
            abort(403, 'Unauthorized action.');
        }

        $pairs = Pair::all();
        $tracks = Track::all();
        $result_statuses = ResultStatus::all();
        return view('results.edit', compact('result', 'pairs', 'tracks', 'result_statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = Result::findOrFail($id);

        if ($request->user()->cannot('update', $result)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'pair_id' => 'required|integer|exists:pairs,id',
            'track_id' => 'required|integer|exists:tracks,id',
            'result_status_id' => 'required|integer|exists:result_statuses,id',
            'points' => 'required|integer'
        ]);

        $validated['recorded_by_user_id'] = Auth::id();
        $result->update($validated);
        return redirect()->route('result.show', $result->id)
            ->with('success', 'Result updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Result $result)
    {
        if ($request->user()->cannot('delete', $result)) {
            abort(403, 'Unauthorized action.');
        }

        $result->delete();
        return redirect()->route('result.index')
            ->with('success', 'Result deleted.');
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Result::class)) {
            abort(403, 'Unauthorized action.');
        }

        $results = Result::onlyTrashed()->get();
        return view('results.trashed', compact('results'));
    }

    public function restore(Request $request, string $id)
    {
        $result = Result::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', Result::class)) {
            abort(403, 'Unauthorized action.');
        }

        $result->restore();
        return redirect()->route('result.trashed')
            ->with('success', 'Result restored.');
    }

    public function forceDelete(Request $request, string $id)
    {
        $result = Result::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', Result::class)) {
            abort(403, 'Unauthorized action.');
        }
        $result->forceDelete();
        return redirect()->route('result.trashed')
            ->with('success', 'Result permanently deleted.');
    }
}
