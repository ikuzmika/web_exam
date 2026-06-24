<x-layout>
    <x-slot name="title">
        {{ __('handlers.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('handlers.title') }}</h1>

                <p>
                    {{ __('handlers.index_description') }}
                </p>
            </div>

            @auth
                <a href="{{ route('handler.create') }}" class="btn btn-primary">
                    {{ __('handlers.add_handler') }}
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="handlerSearch" class="form-label">
                    {{ __('handlers.search_handler') }}
                </label>

                <input
                    type="text"
                    id="handlerSearch"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="{{ __('handlers.search_placeholder') }}"
                >
            </div>
        </div>
    </section>

    <section class="handlers-grid">
        @forelse($handlers as $handler)
            <article
                class="handler-card handler-card-js"
                data-search="
                    {{ $handler->name }}
                    {{ $handler->surname }}
                    {{ $handler->email }}
                    {{ $handler->contact_number }}
                "
            >
                <h2>
                    {{ $handler->name }} {{ $handler->surname }}
                </h2>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#handlerModal{{ $handler->id }}"
                >
                    {{ __('common.view_details') }}
                </button>
            </article>

            <div class="modal fade" id="handlerModal{{ $handler->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content handler-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $handler->name }} {{ $handler->surname }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>{{ __('handlers.name') }}:</strong>
                                {{ $handler->name }}
                            </p>

                            <p>
                                <strong>{{ __('handlers.surname') }}:</strong>
                                {{ $handler->surname }}
                            </p>

                            <p>
                                <strong>{{ __('handlers.email') }}:</strong>
                                {{ $handler->email ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('handlers.contact_number') }}:</strong>
                                {{ $handler->contact_number ?? __('common.not_specified') }}
                            </p>
                        </div>

                        <div class="modal-footer">
                            @auth
                                <a href="{{ route('handler.edit', $handler->id) }}" class="btn btn-outline-primary">
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
                <h2>{{ __('handlers.no_handlers') }}</h2>
                <p>{{ __('handlers.no_handlers_description') }}</p>
            </div>
        @endforelse
    </section>

    <script>
        const handlerSearch = document.getElementById('handlerSearch');
        const handlerCards = document.querySelectorAll('.handler-card-js');

        function filterHandlers() {
            const searchText = handlerSearch.value.toLowerCase();

            handlerCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();

                if (cardText.includes(searchText)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        handlerSearch.addEventListener('input', filterHandlers);

        filterHandlers();
    </script>
</x-layout>
