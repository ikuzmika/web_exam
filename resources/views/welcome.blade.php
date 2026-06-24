<x-layout>
    <x-slot name="title">
        {{ __('home.title') }}
    </x-slot>

    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">
                {{ __('home.hero_title') }}
            </h1>

            <p class="hero-text">
                {{ __('home.hero_text') }}
            </p>
        </div>
    </section>

    <section class="home-dashboard">
        <div class="row g-4">

            <div class="col-lg-3">
                <div class="search-panel">
                    <h2>{{ __('home.quick_search') }}</h2>

                    <form id="quickSearchForm">
                        <div class="mb-3">
                            <label for="handlerName" class="form-label">
                                {{ __('home.handler_name') }}
                            </label>

                            <input type="text"
                                   id="handlerName"
                                   class="form-control"
                                   placeholder="{{ __('home.handler_placeholder') }}">
                        </div>

                        <div class="mb-3">
                            <label for="dogName" class="form-label">
                                {{ __('home.dog_name') }}
                            </label>

                            <input type="text"
                                   id="dogName"
                                   class="form-control"
                                   placeholder="{{ __('home.dog_placeholder') }}">
                        </div>

                        <div class="mb-3">
                            <label for="competitionName" class="form-label">
                                {{ __('home.competition_name') }}
                            </label>

                            <input type="text"
                                   id="competitionName"
                                   class="form-control"
                                   placeholder="{{ __('home.competition_placeholder') }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('common.search') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="section-heading">
                    <h2>{{ __('home.planned_competitions') }}</h2>

                    <a href="{{ route('competition.index') }}" class="card-link">
                        {{ __('home.view_all') }}
                    </a>
                </div>

                <div id="plannedCompetitionsList">
                    @forelse($upcomingCompetitions ?? [] as $competition)
                        <div class="competition-preview-card home-competition-card-js"
                             data-search="{{ translate_db($competition->title) }} {{ translate_db(optional($competition->organizer)->venue) }}">
                            <div class="competition-preview-content">
                                <h3>{{ translate_db($competition->title) }}</h3>

                                <p>
                                    <strong>{{ __('common.date') }}:</strong>
                                    {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                                </p>

                                <p>
                                    <strong>{{ __('competitions.venue') }}:</strong>
                                    {{ translate_db(optional($competition->organizer)->venue) ?: __('common.not_specified') }}
                                </p>

                                <a href="{{ route('competition.show', $competition->id) }}" class="btn btn-primary btn-sm">
                                    {{ __('common.open') }}
                                </a>
                            </div>

                            <div class="competition-image-placeholder">
                                {{ __('competitions.competition_image') }}
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <h2>{{ __('home.no_planned_competitions') }}</h2>
                            <p>{{ __('home.no_planned_description') }}</p>
                        </div>
                    @endforelse
                </div>

                <div id="noCompetitionSearchResults" class="empty-state d-none">
                    <h2>{{ __('home.no_matching_competitions') }}</h2>
                    <p>{{ __('home.no_matching_competitions_description') }}</p>
                </div>
            </div>

        </div>
    </section>

    <script>
        const quickSearchForm = document.getElementById('quickSearchForm');

        const handlerNameInput = document.getElementById('handlerName');
        const dogNameInput = document.getElementById('dogName');
        const competitionNameInput = document.getElementById('competitionName');

        const competitionCards = document.querySelectorAll('.home-competition-card-js');
        const noCompetitionSearchResults = document.getElementById('noCompetitionSearchResults');

        const handlerIndexUrl = @json(route('handler.index'));
        const dogIndexUrl = @json(route('dog.index'));

        function redirectWithSearch(url, searchText) {
            window.location.href = url + '?search=' + encodeURIComponent(searchText);
        }

        function filterPlannedCompetitions(searchText) {
            let visibleCards = 0;
            const normalizedSearch = searchText.toLowerCase();

            competitionCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();

                if (normalizedSearch === '' || cardText.includes(normalizedSearch)) {
                    card.style.display = 'flex';
                    visibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noCompetitionSearchResults) {
                if (competitionCards.length > 0 && visibleCards === 0) {
                    noCompetitionSearchResults.classList.remove('d-none');
                } else {
                    noCompetitionSearchResults.classList.add('d-none');
                }
            }
        }

        quickSearchForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const handlerName = handlerNameInput.value.trim();
            const dogName = dogNameInput.value.trim();
            const competitionName = competitionNameInput.value.trim();

            if (handlerName !== '') {
                redirectWithSearch(handlerIndexUrl, handlerName);
                return;
            }

            if (dogName !== '') {
                redirectWithSearch(dogIndexUrl, dogName);
                return;
            }

            filterPlannedCompetitions(competitionName);
        });

        competitionNameInput.addEventListener('input', function () {
            if (handlerNameInput.value.trim() === '' && dogNameInput.value.trim() === '') {
                filterPlannedCompetitions(this.value.trim());
            }
        });
    </script>
</x-layout>
