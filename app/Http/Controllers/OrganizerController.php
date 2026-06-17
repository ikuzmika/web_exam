<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
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
        $organizers = Organizer::all();
        return view('organizers.index', compact('organizers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Organizer::class)) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Organizer $organizer)
    {
        if ($request->user()->cannot('store', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:60',
            'contact_person' => 'max:150',
            'email' => 'unique:organizers|email|max:100',
            'contact_number' => 'max:20',
            'venue' => 'required|max:255',
        ]);

        Organizer::create($validated);

        return redirect()->route('organizer.index')->with('success', 'Organizer created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organizer = Organizer::findOrFail($id);

        return view('organizers.show', compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , string $id)
    {
        $organizer = Organizer::findOrFail($id);

        if ($request->user()->cannot('edit', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizers.edit', compact('organizer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organizer = Organizer::findOrFail($id);

        if ($request->user()->cannot('update', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:60',
            'contact_person' => 'max:150',
            'email' => 'unique:organizers|email|max:100',
            'contact_number' => 'max:20',
            'venue' => 'required|max:255',
        ]);

        $organizer->update($validated);
        return redirect()->route('organizer.show', $organizer->id)->with('success', 'Organizer updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Organizer $organizer)
    {
        if ($request->user()->cannot('delete', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $organizer->delete();
        return redirect()->route('organizer.index')->with('success', 'Organizer deleted.');
    }
}
