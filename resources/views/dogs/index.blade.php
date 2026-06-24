<x-layout>
    <x-slot name="title">
        Dogs
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Dogs</h1>

                <p>
                    View dogs that participate in agility competitions.
                </p>
            </div>

            @auth
                <a href="{{ route('dog.create') }}" class="btn btn-primary">
                    Add dog
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="dogSearch" class="form-label">
                    Search dog
                </label>

                <input
                    type="text"
                    id="dogSearch"
                    class="form-control"
                    placeholder="Enter dog name, handler or size"
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
                    Details
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
                                <strong>Dog:</strong>
                                {{ $dog->name }}
                            </p>

                            <p>
                                <strong>Handler:</strong>
                                {{ optional($dog->handler)->name ?? 'Not specified' }}
                                {{ optional($dog->handler)->surname ?? '' }}
                            </p>

                            <p>
                                <strong>Dog size:</strong>
                                {{ optional($dog->sizeCategory)->name ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Description:</strong>
                                {{ $dog->description ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="modal-footer">
                            @auth
                                <a href="{{ route('dog.edit', $dog->id) }}" class="btn btn-outline-primary">
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
                <h2>No dogs found</h2>
                <p>There are no dogs added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const dogSearch = document.getElementById('dogSearch');
        const dogCards = document.querySelectorAll('.dog-card-js');

        dogSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            dogCards.forEach(function (card) {
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