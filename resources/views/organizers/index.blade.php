<x-layout>
    <x-slot name="title">
        Organizers
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Organizers</h1>

                <p>
                    View organizers of agility competitions.
                </p>
            </div>

            @auth
                <a href="{{ route('organizer.create') }}" class="btn btn-primary">
                    Add organizer
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="organizerSearch" class="form-label">
                    Search organizer
                </label>

                <input
                    type="text"
                    id="organizerSearch"
                    class="form-control"
                    placeholder="Enter organizer, venue or sponsor"
                >
            </div>
        </div>
    </section>

    <section class="organizers-grid">
        @forelse($organizers as $organizer)
            <article
                class="organizer-card organizer-card-js"
                data-search="
                    {{ $organizer->name }}
                    {{ $organizer->venue }}
                    {{ $organizer->contact_person }}
                    {{ $organizer->email }}
                    {{ $organizer->contact_number }}
                    @foreach($organizer->sponsors as $sponsor)
                        {{ $sponsor->name }}
                    @endforeach
                "
            >
                <h2>
                    {{ $organizer->name }}
                </h2>

                <p class="organizer-card-text">
                    {{ $organizer->venue ?? 'Venue not specified' }}
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#organizerModal{{ $organizer->id }}"
                >
                    Details
                </button>
            </article>

            <div class="modal fade" id="organizerModal{{ $organizer->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content organizer-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $organizer->name }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>Organizer:</strong>
                                {{ $organizer->name }}
                            </p>

                            <p>
                                <strong>Venue:</strong>
                                {{ $organizer->venue ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Contact person:</strong>
                                {{ $organizer->contact_person ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Email:</strong>
                                {{ $organizer->email ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Contact number:</strong>
                                {{ $organizer->contact_number ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Sponsors:</strong>
                                @forelse($organizer->sponsors as $sponsor)
                                    {{ $sponsor->name }}@if(!$loop->last), @endif
                                @empty
                                    Not specified
                                @endforelse
                            </p>
                        </div>

                        <div class="modal-footer">
                            @auth
                                <a href="{{ route('organizer.edit', $organizer->id) }}" class="btn btn-outline-primary">
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
                <h2>No organizers found</h2>
                <p>There are no organizers added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const organizerSearch = document.getElementById('organizerSearch');
        const organizerCards = document.querySelectorAll('.organizer-card-js');

        organizerSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            organizerCards.forEach(function (card) {
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