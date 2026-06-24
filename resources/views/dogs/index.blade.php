<x-layout>
    <x-slot name="title">
        {{ __('dogs.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('dogs.title') }}</h1>

                <p>
                    {{ __('dogs.index_description') }}
                </p>
            </div>

            @auth
                <a href="{{ route('dog.create') }}" class="btn btn-primary">
                    {{ __('dogs.add_dog') }}
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="dogSearch" class="form-label">
                    {{ __('dogs.search_dog') }}
                </label>

                <input
                    type="text"
                    id="dogSearch"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="{{ __('dogs.search_placeholder') }}"
                >
            </div>
        </div>
    </section>

    <section class="dogs-grid">
        @forelse($dogs as $dog)
            <article
                class="dog-card dog-card-js"
                data-search="
                {{ $dog->name }}
                {{ optional($dog->handler)->name }}
                {{ optional($dog->handler)->surname }}
                {{ optional($dog->sizeCategory)->name }}
                {{ $dog->description }}
            "
            >
                <h2>
                    {{ $dog->name }}
                </h2>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#dogModal{{ $dog->id }}"
                >
                    {{ __('common.view_details') }}
                </button>
            </article>

            <div class="modal fade" id="dogModal{{ $dog->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content dog-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $dog->name }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>{{ __('dogs.dog') }}:</strong>
                                {{ $dog->name }}
                            </p>

                            <p>
                                <strong>{{ __('dogs.handler') }}:</strong>
                                {{ optional($dog->handler)->name ?? __('common.not_specified') }}
                                {{ optional($dog->handler)->surname ?? '' }}
                            </p>

                            <p>
                                <strong>{{ __('dogs.dog_size') }}:</strong>
                                {{ optional($dog->sizeCategory)->name ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('dogs.description') }}:</strong>
                                {{ translate_db($dog->description) ?: __('common.not_specified') }}
                            </p>
                        </div>

                        <div class="modal-footer">
                            @auth
                                <a href="{{ route('dog.edit', $dog->id) }}" class="btn btn-outline-primary">
                                    {{ __('common.edit') }}
                                </a>
                            @endauth

                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                {{ __('common.close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>{{ __('dogs.no_dogs') }}</h2>
                <p>{{ __('dogs.no_dogs_description') }}</p>
            </div>
        @endforelse
    </section>

    <script>
        const dogSearch = document.getElementById('dogSearch');
        const dogCards = document.querySelectorAll('.dog-card-js');

        function filterDogs() {
            const searchText = dogSearch.value.toLowerCase();

            dogCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();

                if (cardText.includes(searchText)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        dogSearch.addEventListener('input', filterDogs);

        filterDogs();
    </script>
</x-layout>
