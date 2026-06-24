<x-layout>
    <x-slot name="title">
        Sponsors
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Sponsors</h1>

                <p>
                    View sponsors that support agility competitions and organizers.
                </p>
            </div>

            @can('create', App\Models\Sponsor::class)
                <a href="{{ route('sponsor.create') }}" class="btn btn-primary">
                    Add sponsor
                </a>
            @endcan
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="sponsorSearch" class="form-label">
                    Search sponsor
                </label>

                <input
                    type="text"
                    id="sponsorSearch"
                    class="form-control"
                    placeholder="Enter sponsor, email or organizer"
                >
            </div>
        </div>
    </section>

    <section class="sponsors-grid">
        @forelse($sponsors as $sponsor)
            <article
                class="sponsor-card sponsor-card-js"
                data-search="
                    {{ $sponsor->name }}
                    {{ $sponsor->email }}
                    {{ $sponsor->description }}
                    @foreach($sponsor->organizer as $organizer)
                        {{ $organizer->name }}
                    @endforeach
                "
            >
                <h2>
                    {{ $sponsor->name }}
                </h2>

                <p class="sponsor-card-text">
                    {{ $sponsor->email ?? 'Email not specified' }}
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#sponsorModal{{ $sponsor->id }}"
                >
                    Details
                </button>
            </article>

            <div class="modal fade" id="sponsorModal{{ $sponsor->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content sponsor-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $sponsor->name }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>Sponsor:</strong>
                                {{ $sponsor->name }}
                            </p>

                            <p>
                                <strong>Email:</strong>
                                {{ $sponsor->email ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Description:</strong>
                                {{ $sponsor->description ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Organizers:</strong>
                                @forelse($sponsor->organizer as $organizer)
                                    {{ $organizer->name }}@if(!$loop->last), @endif
                                @empty
                                    Not specified
                                @endforelse
                            </p>
                        </div>

                        <div class="modal-footer">
                            @can('update', $sponsor)
                                <a href="{{ route('sponsor.edit', $sponsor->id) }}" class="btn btn-outline-primary">
                                    Edit
                                </a>
                            @endcan

                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>No sponsors found</h2>
                <p>There are no sponsors added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const sponsorSearch = document.getElementById('sponsorSearch');
        const sponsorCards = document.querySelectorAll('.sponsor-card-js');

        sponsorSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            sponsorCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();

                if (cardText.includes(searchText)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-layout>