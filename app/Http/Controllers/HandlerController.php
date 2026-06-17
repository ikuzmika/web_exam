<?php

namespace App\Http\Controllers;

use App\Models\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class HandlerController extends Controller
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
        $handlers = Handler::all();
        return view('handlers.index', compact('handlers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Handler::class)) {
            abort(403, 'Unauthorized action.');
        }

        return view('handlers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Handler $handler)
    {
        if ($request->user()->cannot('store', $handler)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:60',
            'surname' => 'required|max:60',
            'email' => 'email|max:20|unique:handlers',
            'contact_number' => 'integer|digits:20',
        ]);

        $validated['cerated_by_user_id'] = Auth::id();

        Handler::create($validated);

        return redirect()->route('handler.index')->with('success', 'Handler created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $handler = Handler::findOrFail($id);

        return view('handlers.show', compact('handler'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $handler = Handler::findOrFail($id);

        if ($request->user()->cannot('update', $handler)) {
            abort(403, 'Unauthorized action.');
        }

        return view('handlers.edit', compact('handler'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $handler = Handler::findOrFail($id);

        if ($request->user()->cannot('update', $handler)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:60',
            'surname' => 'required|max:60',
            'email' => 'email|max:20|unique:handlers',
            'contact_number' => 'integer|digits:20',
        ]);

        $validated['cerated_by_user_id'] = Auth::id();

        $handler->update($validated);
        return redirect()->route('handler.show', $handler->id)->with('success', 'Handler updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Handler $handler)
    {
        if ($request->user()->cannot('delete', $handler)) {
            abort(403, 'Unauthorized action.');
        }

        $handler->delete();
        return redirect()->route('handler.index')->with('success', 'Handler deleted.');
    }
}
