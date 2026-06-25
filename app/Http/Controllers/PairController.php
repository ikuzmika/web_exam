<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Handler;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PairController extends Controller
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
        $pairs = Pair::with([
            'dog.handler',
            'dog.sizeCategory',
        ])->get();
        return view('pairs.index', compact('pairs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Pair::class)) {
            abort(403, 'Unauthorized action.');
        }

        $handlers = Handler::orderBy('surname')
            ->orderBy('name')
            ->get();

        $dogs = Dog::with(['handler', 'sizeCategory'])
            ->whereDoesntHave('pair')
            ->orderBy('name')
            ->get();

        return view('pairs.create', compact('dogs', 'handlers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pair $pair)
    {
        if ($request->user()->cannot('create', $pair)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'handler_id' => 'required|exists:handlers,id',
            'dog_id' => 'required|exists:dogs,id|unique:pairs,dog_id',
            'active_from' => 'required|date',
            'active_until' => 'nullable|date|after_or_equal:active_from',
        ]);

        $dog = Dog::findOrFail($validated['dog_id']);

        $dog->update([
            'handler_id' => $validated['handler_id'],
        ]);

        Pair::create([
            'created_by_user_id' => Auth::id(),
            'dog_id' => $validated['dog_id'],
            'active_from' => $validated['active_from'],
            'active_until' => $validated['active_until'] ?? null,
        ]);

        return redirect()->route('pair.index')
            ->with('success', __('controllers.new_pair'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pair = Pair::with('dog')->findOrFail($id);
        return view('pairs.show', compact('pair'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , Pair $pair)
    {
        if ($request->user()->cannot('update', $pair)) {
            abort(403, 'Unauthorized action.');
        }

        $pair->load('dog.handler', 'dog.sizeCategory');

        $handlers = Handler::orderBy('surname')
            ->orderBy('name')
            ->get();

        $dogs = Dog::with(['handler', 'sizeCategory'])
            ->where(function ($query) use ($pair) {
                $query->whereDoesntHave('pair')
                    ->orWhere('id', $pair->dog_id);
            })
            ->orderBy('name')
            ->get();

        return view('pairs.edit', compact('pair', 'dogs', 'handlers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pair = Pair::findOrFail($id);

        if ($request->user()->cannot('update', $pair)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'handler_id' => 'required|exists:handlers,id',

            'dog_id' => [
                'required',
                'exists:dogs,id',
                Rule::unique('pairs', 'dog_id')->ignore($pair->id),
            ],

            'active_from' => 'required|date',
            'active_until' => 'nullable|date|after_or_equal:active_from',
        ]);

        $dog = Dog::findOrFail($validated['dog_id']);

        $dog->update([
            'handler_id' => $validated['handler_id'],
        ]);

        $pair->update([
            'created_by_user_id' => Auth::id(),
            'dog_id' => $validated['dog_id'],
            'active_from' => $validated['active_from'],
            'active_until' => $validated['active_until'] ?? null,
        ]);
        return redirect()->route('pair.index')
            ->with('success', __('controllers.updated_pair'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , Pair $pair)
    {
        if ($request->user()->cannot('delete', $pair)) {
            abort(403, 'Unauthorized action.');
        }

        $pair->delete();
        return redirect()->route('pair.index')
            ->with('success', __('controllers.deleted_pair'));
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Pair::class)) {
            abort(403, 'Unauthorized action.');
        }

        $pairs = Pair::onlyTrashed()->get();
        return view('pairs.trashed', compact('pairs'));
    }

    public function restore(Request $request, string $id)
    {
        $pair = Pair::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', $pair)) {
            abort(403, 'Unauthorized action.');
        }
        $pair->restore();
        return redirect()->route('pair.trashed')
            ->with('success', __('controllers.restored_pair'));
    }

    public function forceDelete(Request $request, string $id)
    {
        $pair = Pair::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $pair)) {
            abort(403, 'Unauthorized action.');
        }

        $pair->forceDelete();
        return redirect()->route('pair.trashed')
            ->with('success', __('controllers.force_deleted_pair'));
    }
}
