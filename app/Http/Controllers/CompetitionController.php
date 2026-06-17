<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Handler;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Psy\Command\CopyCommand;

class CompetitionController extends Controller
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
        $competitions = Competition::all();
        return view('competitions.index', compact('competitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Competition::class)) {
            abort(403, 'Unauthorized action.');
        }

        $organizers = Organizer::all();
        $judges = Handler::all();
        return view('competitions.create', compact('organizers', 'judges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Competition $competition)
    {
        if ($request->user()->cannot('store', $competition)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'organizer_id' => 'required|integer|exists:organizers,id',
            'judge_id' => 'required|integer|exists:judges,id',
            'title' => 'required|string|min:3|max:255',
            'date' => 'required|date',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        Competition::create($validated);

        return redirect()->route('competition.index')->with('success', 'Competition created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $competition = Competition::with(['organizer', 'judge'])->findOrFail($id);

        return view('competitions.show', compact('competition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $competition = Competition::findOrFail($id);

        if ($request->user()->cannot('edit', $competition)) {
            abort(403, 'Unauthorized action.');
        }

        $organizers = Organizer::all();
        $judges = Handler::all();
        return view('competitions.edit', compact('competition', 'organizers', 'judges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $competition = Competition::findOrFail($id);

        if ($request->user()->cannot('update', $competition)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'organizer_id' => 'required|integer|exists:organizers,id',
            'judge_id' => 'required|integer|exists:judges,id',
            'title' => 'required|string|min:3|max:255',
            'date' => 'required|date',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        $competition->update($validated);
        return redirect()->route('competition.show', $competition->id)->with('success', 'Competition updated.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Competition $competition)
    {
        if ($request->user()->cannot('delete', $competition)) {
            abort(403, 'Unauthorized action.');
        }

        $competition->delete();
        return redirect()->route('competition.index')->with('success', 'Competition deleted.');
    }
}
