<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
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
        $sponsors = Sponsor::with('organizer')->get();

        return view('sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Sponsor::class)) {
            abort(403, 'Unauthorized action.');
        }

        $organizers = Organizer::orderBy('name')->get();

        return view('sponsors.create', compact('organizers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Sponsor::class)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:150',
            'description' => 'nullable',
            'email' => 'email|max:150',

            'organizers' => 'nullable|array',
            'organizers.*.selected' => 'nullable|boolean',
            'organizers.*.contribution_type' => 'nullable|max:100',
            'organizers.*.contribution_amount' => 'nullable|numeric|min:0',
        ]);

        $sponsor = Sponsor::create([
            'created_by_user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        $sponsor->organizers()->sync($this->prepareOrganizerSyncData($request));

        return redirect()->route('sponsor.show', $sponsor->id)
            ->with('success', 'Sponsor created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sponsor = Sponsor::with('organizer')->findOrFail($id);

        return view('sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Sponsor $sponsor)
    {
        if ($request->user()->cannot('update', $sponsor)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsor->load('organizer');

        $organizer = Organizer::orderBY('name')->get();
        return view('sponsors.edit', compact('sponsor', 'organizer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sponsor = Sponsor::findOrFail($id);

        if ($request->user()->cannot('update', $sponsor)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:150',
            'description' => 'nullable',
            'email' => 'email|max:150',

            'organizers' => 'nullable|array',
            'organizers.*.selected' => 'nullable|boolean',
            'organizers.*.contribution_type' => 'nullable|max:100',
            'organizers.*.contribution_amount' => 'nullable|numeric|min:0',
        ]);

        $sponsor->update([
            'created_by_user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        $sponsor->organizers()->sync($this->prepareOrganizerSyncData($request));

        return redirect()->route('sponsor.show', $sponsor->id)
            ->with('success', 'Sponsor updated.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Sponsor $sponsor)
    {
        if ($request->user()->cannot('delete', $sponsor)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsor->delete();
        return redirect()->route('sponsor.index')
            ->with('success', 'Sponsor deleted.');
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Sponsor::class)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsors = Sponsor::onlyTrashed()
            ->with('organizer')->get();

        return view('sponsors.trashed', compact('sponsors'));
    }

    public function restore(Request $request,string $id)
    {
        $sponsor = Sponsor::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', $sponsor)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsor->restore();
        return redirect()->route('sponsor.trashed')
            ->with('success', 'Sponsor restored.');
    }

    public function forceDelete(Request $request, string $id)
    {
        $sponsor = Sponsor::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $sponsor)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsor->forceDelete();
        return redirect()->route('sponsor.trashed')
            ->with('success', 'Sponsor permanently deleted.');
    }

    private function prepareOrganizerSyncData(Request $request): array
    {
        $syncData = [];

        foreach ($request->input('organizers', []) as $organizerId => $data) {
            if (isset($data['selected'])) {
                $syncData[$organizerId] = [
                    'contribution_type' => $data['contribution_type'] ?? null,
                    'contribution_amount' => $data['contribution_amount'] ?? null,
                ];
            }
        }

        return $syncData;
    }
}
