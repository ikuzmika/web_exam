<x-layout>
    <x-slot name="title">
        {{ __('competitions.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('competitions.agility_competitions') }}</h1>

                <p>
                    {{ __('competitions.index_description') }}
                </p>
            </div>

            @can('create', App\Models\Competition::class)
                <a href="{{ route('competition.create') }}" class="btn btn-primary">
                    {{ __('competitions.add_competition') }}
                </a>
            @endcan
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="competitionSearch" class="form-label">
                    {{ __('competitions.search_competition') }}
                </label>

                <input
                    type="text"
                    id="competitionSearch"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="{{ __('competitions.search_placeholder') }}"
                >
            </div>
        </div>
    </section>

    <section class="content-list">
        @forelse($competitions as $competition)
            <article
                class="competition-preview-card competition-card-js"
                data-search="
                    {{ $competition->title }}
                    {{ translate_db($competition->title) }}
                    {{ optional($competition->organizer)->venue }}
                    {{ translate_db(optional($competition->organizer)->venue) }}
                "
            >
                <div class="competition-preview-content">
                    <h3>{{ translate_db($competition->title) }}</h3>

                    <p>
                        <strong>{{ __('competitions.date') }}:</strong>
                        {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                    </p>

                    <p>
                        <strong>{{ __('competitions.venue') }}:</strong>
                        {{ optional($competition->organizer)->venue ?: __('common.not_specified') }}
                    </p>

                    <div class="competition-preview-actions">
                        <a href="{{ route('competition.show', $competition->id) }}" class="btn btn-primary btn-sm">
                            {{ __('common.view_details') }}
                        </a>

                        @can('update', $competition)
                            <a href="{{ route('competition.edit', $competition->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                {{ __('common.edit') }}
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="competition-image-placeholder">
                    {{ __('competitions.competition_image') }}
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('competitions.no_competitions') }}</h2>
                <p>{{ __('competitions.no_competitions_description') }}</p>
            </div>
        @endforelse
    </section>

    <script>
        const competitionSearch = document.getElementById('competitionSearch');
        const competitionCards = document.querySelectorAll('.competition-card-js');

        function filterCompetitions() {
            const searchText = competitionSearch.value.toLowerCase();

            competitionCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();

                if (searchText === '' || cardText.includes(searchText)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        competitionSearch.addEventListener('input', filterCompetitions);

        filterCompetitions();
    </script>
</x-layout>
