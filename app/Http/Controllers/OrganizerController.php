<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Sponsor;
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
        $organizers = Organizer::with('sponsors')->get();

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

        $sponsors = Sponsor::orderBy('name')->get();

        return view('organizers.create', compact('sponsors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Organizer::class)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|max:60',
            'contact_person' => 'string|max:150',
            'email' => 'unique:organizers|email|max:100',
            'contact_number' => 'max:20',
            'venue' => 'required|max:255',

            'sponsors' => 'nullable|array',
            'sponsors.*.selected' => 'nullable|boolean',
            'sponsors.*.contribution_type' => 'nullable|max:100',
            'sponsors.*.amount' => 'nullable|numeric|min:0',
        ]);

        $organizer = Organizer::create([
            'created_by_user_id' => Auth::id(),
            'name' => $validated['name'],
            'contact_person' => $validated['contact_person'] ?? null,
            'email' => $validated['email'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'venue' => $validated['venue'],
        ]);

        $organizer->sponsors()->sync($this->prepareSponsorSyncData($request));

        return redirect()->route('organizer.index')
            ->with('success', __('controllers.new_organizer'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organizer = Organizer::with('sponsors')->findOrFail($id);

        return view('organizers.show', compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $organizer = Organizer::with('sponsors')->findOrFail($id);

        if ($request->user()->cannot('update', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsors = Sponsor::orderBy('name')->get();

        return view('organizers.edit', compact('organizer', 'sponsors'));
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
            'email' => 'unique:organizers|email|max:100' . $organizer->id,
            'contact_number' => 'max:20',
            'venue' => 'required|max:255',

            'sponsors' => 'nullable|array',
            'sponsors.*.selected' => 'nullable|boolean',
            'sponsors.*.contribution_type' => 'nullable|max:100',
            'sponsors.*.contribution_amount' => 'nullable|numeric|min:0',
        ]);

        $organizer->update([
            'created_by_user_id' => Auth::id(),
            'name' => $validated['name'],
            'contact_person' => $validated['contact_person'] ?? null,
            'email' => $validated['email'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'venue' => $validated['venue'],
        ]);

        $organizer->sponsors()->sync($this->prepareSponsorSyncData($request));
        return redirect()->route('organizer.show', $organizer->id)
            ->with('success', __('controllers.updated_organizer'));
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
        return redirect()->route('organizer.index')
            ->with('success', __('controllers.deleted_organizer'));
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Organizer::class)) {
            abort(403, 'Unauthorized action.');
        }

        $organizers = Organizer::onlyTrashed()
            ->with('sponsors')->get();

        return view('organizers.trashed', compact('organizers'));
    }

    public function restore(Request $request, string $id)
    {
        $organizer = Organizer::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $organizer->restore();
        return redirect()->route('organizer.trashed')
            ->with('success', __('controllers.restored_organizer'));
    }

    public function forceDelete(Request $request, string $id)
    {
        $organizer = Organizer::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $organizer->forceDelete();
        return redirect()->route('organizer.trashed')
            ->with('success', __('controllers.force_deleted_handler'));
    }

    private function prepareSponsorSyncData(Request $request): array
    {
        $syncData = [];

        foreach ($request->input('sponsors', []) as $sponsorId => $data) {
            if (isset($data['selected'])) {
                $syncData[$sponsorId] = [
                    'contribution_type' => $data['contribution_type'] ?? null,
                    'contribution_amount' => $data['contribution_amount'] ?? null,
                ];
            }
        }

        return $syncData;
    }
}
