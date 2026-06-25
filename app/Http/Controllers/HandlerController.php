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
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Handler::class)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'surname' => 'required|string|max:60',
            'email' => 'nullable|email|max:20|unique:handlers,email',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        Handler::create($validated);

        return redirect()->route('handler.index')
            ->with('success', __('controllers.new_handler'));
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
            'name' => 'required|string|max:60',
            'surname' => 'required|string|max:60',
            'email' => 'nullable|email|max:20|unique:handlers,email,' . $handler->id,
            'contact_number' => 'nullable|string|max:20',
        ]);

        $handler->update($validated);
        return redirect()->route('handler.index')
            ->with('success', __('controllers.updated_handler'));
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
        return redirect()->route('handler.index')
            ->with('success', __('controllers.deleted_handler'));
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Handler::class)) {
            abort(403, 'Unauthorized action.');
        }

        $handlers = Handler::onlyTrashed()->get();

        return view('handlers.trashed', compact('handlers'));
    }

    public function restore(Request $request, string $id)
    {
        $handler = Handler::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', $handler)) {
            abort(403, 'Unauthorized action.');
        }

        $handler->restore();
        return redirect()->route('handler.trashed')
            ->with('success', __('controllers.restored_handler'));
    }

    public function forceDelete(Request $request, string $id)
    {
        $handler = Handler::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $handler)) {
            abort(403, 'Unauthorized action.');
        }

        $handler->forceDelete();
        return redirect()->route('handler.trashed')
            ->with('success', __('controllers.force_deleted_handler'));
    }
}
