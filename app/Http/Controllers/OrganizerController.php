<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrganizerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $organizers = Organizer::with('sponsors')->get();

        return view('organizers.index', compact('organizers'));
    }

    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Organizer::class)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsors = Sponsor::orderBy('name')->get();

        return view('organizers.create', compact('sponsors'));
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Organizer::class)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'contact_person' => 'nullable|string|max:150',
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('organizers', 'email'),
            ],
            'contact_number' => 'nullable|string|max:20',
            'venue' => 'required|string|max:255',

            'sponsors' => 'nullable|array',
            'sponsors.*.selected' => 'nullable|boolean',
            'sponsors.*.contribution_type' => 'nullable|string|max:100',
            'sponsors.*.contribution_amount' => 'nullable|numeric|min:0',
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

        return redirect()
            ->route('organizer.index')
            ->with('success', __('controllers.new_organizer'));
    }

    public function show(string $id)
    {
        $organizer = Organizer::with('sponsors')->findOrFail($id);

        return view('organizers.show', compact('organizer'));
    }

    public function edit(Request $request, string $id)
    {
        $organizer = Organizer::with('sponsors')->findOrFail($id);

        if ($request->user()->cannot('update', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $sponsors = Sponsor::orderBy('name')->get();

        return view('organizers.edit', compact('organizer', 'sponsors'));
    }

    public function update(Request $request, string $id)
    {
        $organizer = Organizer::with('sponsors')->findOrFail($id);

        if ($request->user()->cannot('update', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'contact_person' => 'nullable|string|max:150',
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('organizers', 'email')->ignore($organizer->id),
            ],
            'contact_number' => 'nullable|string|max:20',
            'venue' => 'required|string|max:255',

            'sponsors' => 'nullable|array',
            'sponsors.*.selected' => 'nullable|boolean',
            'sponsors.*.contribution_type' => 'nullable|string|max:100',
            'sponsors.*.contribution_amount' => 'nullable|numeric|min:0',
        ]);

        $organizer->update([
            'name' => $validated['name'],
            'contact_person' => $validated['contact_person'] ?? null,
            'email' => $validated['email'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'venue' => $validated['venue'],
        ]);

        $organizer->sponsors()->sync($this->prepareSponsorSyncData($request));

        return redirect()
            ->route('organizer.index')
            ->with('success', __('controllers.updated_organizer'));
    }

    public function destroy(Request $request, Organizer $organizer)
    {
        if ($request->user()->cannot('delete', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $organizer->delete();

        return redirect()
            ->route('organizer.index')
            ->with('success', __('controllers.deleted_organizer'));
    }

    public function trashed(Request $request)
    {
        if ($request->user()->cannot('viewTrashed', Organizer::class)) {
            abort(403, 'Unauthorized action.');
        }

        $organizers = Organizer::onlyTrashed()
            ->with('sponsors')
            ->get();

        return view('organizers.trashed', compact('organizers'));
    }

    public function restore(Request $request, string $id)
    {
        $organizer = Organizer::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('restore', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $organizer->restore();

        return redirect()
            ->route('organizer.trashed')
            ->with('success', __('controllers.restored_organizer'));
    }

    public function forceDelete(Request $request, string $id)
    {
        $organizer = Organizer::onlyTrashed()->findOrFail($id);

        if ($request->user()->cannot('forceDelete', $organizer)) {
            abort(403, 'Unauthorized action.');
        }

        $organizer->sponsors()->detach();
        $organizer->forceDelete();

        return redirect()
            ->route('organizer.trashed')
            ->with('success', __('controllers.force_deleted_organizer'));
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
