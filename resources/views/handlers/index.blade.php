<x-layout>
    <x-slot name="title">
        Handlers
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Handlers</h1>

                <p>
                    View handlers who participate in agility competitions.
                </p>
            </div>

            @auth
                <a href="{{ route('handler.create') }}" class="btn btn-primary">
                    Add handler
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="handlerSearch" class="form-label">
                    Search handler
                </label>

                <input
                    type="text"
                    id="handlerSearch"
                    class="form-control"
                    placeholder="Enter handler name, email or phone"
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
                    Details
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
                                <strong>Name:</strong>
                                {{ $handler->name }}
                            </p>

                            <p>
                                <strong>Surname:</strong>
                                {{ $handler->surname }}
                            </p>

                            <p>
                                <strong>Email:</strong>
                                {{ $handler->email ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Contact number:</strong>
                                {{ $handler->contact_number ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="modal-footer">
                            @auth
                                <a href="{{ route('handler.edit', $handler->id) }}" class="btn btn-outline-primary">
                                    Edit
                                </a>
                            @endauth

                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>No handlers found</h2>
                <p>There are no handlers added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const handlerSearch = document.getElementById('handlerSearch');
        const handlerCards = document.querySelectorAll('.handler-card-js');

        handlerSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            handlerCards.forEach(function (card) {
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