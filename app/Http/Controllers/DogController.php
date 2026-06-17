<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Handler;
use App\Models\SizeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class DogController extends Controller
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
        $dogs = Dog::all();
        return view('dogs.index', compact('dogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannnot('create', Dog::class)) {
            abort(403, 'Unauthorized action.');
        }

        $handler = Handler::all();
        $size = SizeCategory::all();
        return view('dogs.create', compact('handler', 'size'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dog $dog)
    {
        if ($request->user()->cannnot('store', $dog)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'handler_id' => 'required|integer|exists:handlers,id',
            'size_category_id' => 'required|integer|exists:size_categories,id',
            'name' => 'required|string|max:100',
            'description' => 'string|max:255',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        Dog::create($validated);

        return redirect()->route('dog.index')->with('success', 'Dog has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dog = Dog::with(['handler', 'sizeCategory'])->findOrFail($id);

        return view('dogs.show', compact('dog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request ,string $id)
    {
        $dog = Dog::findOrFail($id);

        if ($request->user()->cannnot('edit', $dog)) {
            abort(403, 'Unauthorized action.');
        }

        $handler = Handler::all();
        $size = SizeCategory::all();
        return view('dogs.edit', compact('dog', 'handler', 'size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dog = Dog::findOrFail($id);

        if ($request->user()->cannnot('update', $dog)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'handler_id' => 'required|integer|exists:handlers,id',
            'size_category_id' => 'required|integer|exists:size_categories,id',
            'name' => 'required|string|max:100',
            'description' => 'string|max:255',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        $dog->update($validated);
        return redirect()->route('dog.show', $dog->id)->with('success', 'Dog has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , Dog $dog)
    {
        if ($request->user()->cannnot('delete', $dog)) {
            abort(403, 'Unauthorized action.');
        }

        $dog->delete();
        return redirect()->route('dog.index')->with('success', 'Dog has been deleted.');
    }
}
