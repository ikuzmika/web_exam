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

            <div class="d-flex gap-2">
                @can('create', App\Models\Competition::class)
                    <a href="{{ route('competition.create') }}" class="btn btn-primary">
                        {{ __('competitions.add_competition') }}
                    </a>
                @endcan

                @can('viewTrashed', App\Models\Competition::class)
                    <a href="{{ route('competition.trashed') }}" class="btn btn-outline-danger">
                        {{ __('competitions.deleted_competitions') }}
                    </a>
                @endcan
            </div>
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
                        @can('delete', $competition)
                            <form method="POST"
                                  action="{{ route('competition.destroy', $competition->id) }}"
                                  onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    {{ __('common.delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                @php
                    $competitionPhoto = $competition->photo
                        ->where('title', 'Competition card photo')
                        ->first();

                    if (!$competitionPhoto) {
                        $competitionPhoto = $competition->photo->first();
                    }
                @endphp

                @if($competitionPhoto)
                    <div class="competition-image-placeholder has-image">
                        <img
                            src="{{ asset('storage/' . $competitionPhoto->file_path) }}"
                            alt="{{ __('competitions.competition_image') }}"
                            class="competition-card-image"
                        >
                    </div>
                @else
                    <div class="competition-image-placeholder">
                        {{ __('competitions.competition_image') }}
                    </div>
                @endif
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
