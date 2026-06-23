<x-layout>
    <x-slot name="title">
        Competitions
    </x-slot>

    {{-- Competitions page header and search --}}
    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Agility competitions</h1>

                <p>
                    View agility competitions, dates and venues.
                </p>
            </div>

            @auth
                <a href="{{ route('competition.create') }}" class="btn btn-primary">
                    Add competition
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="competitionSearch" class="form-label">
                    Search competition
                </label>

                <input
                    type="text"
                    id="competitionSearch"
                    class="form-control"
                    placeholder="Enter competition name or venue"
                >
            </div>
        </div>
    </section>

    {{-- Competition list --}}
    <section class="content-list">
        @forelse($competitions as $competition)
            <article
                class="competition-preview-card competition-card-js"
                data-search="{{ $competition->title }} {{ optional($competition->organizer)->venue }}"
            >
                <div class="competition-preview-content">
                    <h3>{{ $competition->title }}</h3>

                    <p>
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                    </p>

                    <p>
                        <strong>Venue:</strong>
                        {{ optional($competition->organizer)->venue ?? 'Not specified' }}
                    </p>

                    <div class="competition-preview-actions">
                        <a href="{{ route('competition.show', $competition->id) }}" class="btn btn-primary btn-sm">
                            Open
                        </a>

                        @auth
                            <a href="{{ route('competition.edit', $competition->id) }}" class="btn btn-outline-primary btn-sm">
                                Edit
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="competition-image-placeholder">
                    Competition image
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>No competitions found</h2>
                <p>There are no competitions added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const competitionSearch = document.getElementById('competitionSearch');
        const competitionCards = document.querySelectorAll('.competition-card-js');

        competitionSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            competitionCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();

                if (cardText.includes(searchText)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-layout>