<x-layout>
    <x-slot name="title">
        Tracks
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Tracks</h1>

                <p>
                    View competition tracks and their difficulty levels.
                </p>
            </div>

            @can('create', App\Models\Track::class)
                <a href="{{ route('track.create') }}" class="btn btn-primary">
                    Add track
                </a>
            @endcan
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="trackSearch" class="form-label">
                    Search track
                </label>

                <input
                    type="text"
                    id="trackSearch"
                    class="form-control"
                    placeholder="Enter track, competition or level"
                >
            </div>
        </div>
    </section>

    <section class="tracks-grid">
        @forelse($tracks as $track)
            <article
                class="track-card track-card-js"
                data-search="
                    {{ $track->name }}
                    {{ optional($track->competition)->title }}
                    {{ optional($track->difficultyLevel)->name }}
                "
            >
                <h2>
                    Track {{ $track->name }}
                </h2>

                <p class="track-card-text">
                    {{ optional($track->competition)->title ?? 'Competition not specified' }}
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#trackModal{{ $track->id }}"
                >
                    Details
                </button>
            </article>

            <div class="modal fade" id="trackModal{{ $track->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content track-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $track->name }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>Track:</strong>
                                {{ $track->name }}
                            </p>

                            <p>
                                <strong>Competition:</strong>
                                {{ optional($track->competition)->title ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Competition date:</strong>
                                @if(optional($track->competition)->date)
                                    {{ \Carbon\Carbon::parse($track->competition->date)->format('d.m.Y') }}
                                @else
                                    Not specified
                                @endif
                            </p>

                            <p>
                                <strong>Difficulty level:</strong>
                                {{ optional($track->difficultyLevel)->name ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="modal-footer">
                            @can('update', $track)
                                <a href="{{ route('track.edit', $track->id) }}" class="btn btn-outline-primary">
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
                <h2>No tracks found</h2>
                <p>There are no tracks added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const trackSearch = document.getElementById('trackSearch');
        const trackCards = document.querySelectorAll('.track-card-js');

        trackSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            trackCards.forEach(function (card) {
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