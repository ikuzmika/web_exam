<x-layout>
    <x-slot name="title">
        Pairs
    </x-slot>

    {{-- Pairs page header and search --}}
    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Agility pairs</h1>
                <p>View agility pairs, handlers, dogs and size categories.</p>
            </div>

            @auth
                <a href="{{ route('pair.create') }}" class="btn btn-primary">
                    Add pair
                </a>
            @endauth
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="pairSearch" class="form-label">
                    Search pair
                </label>

                <input
                    type="text"
                    id="pairSearch"
                    class="form-control"
                    placeholder="Enter handler or dog name"
                >
            </div>
        </div>
    </section>

    {{-- Pair list --}}
    <section class="pairs-grid">
        @forelse($pairs as $pair)
            <article
                class="pair-card pair-card-js"
                data-search="
                    {{ optional(optional($pair->dog)->handler)->name }}
                    {{ optional(optional($pair->dog)->handler)->surname }}
                    {{ optional($pair->dog)->name }}
                "
            >
                <h2>
                    {{ optional(optional($pair->dog)->handler)->name ?? 'Unknown' }}
                    {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                    &
                    {{ optional($pair->dog)->name ?? 'Unknown dog' }}
                </h2>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#pairModal{{ $pair->id }}"
                >
                    Details
                </button>
            </article>

            <div class="modal fade" id="pairModal{{ $pair->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content pair-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ optional(optional($pair->dog)->handler)->name ?? 'Unknown' }}
                                {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                                &
                                {{ optional($pair->dog)->name ?? 'Unknown dog' }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>Handler:</strong>
                                {{ optional(optional($pair->dog)->handler)->name ?? 'Not specified' }}
                                {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                            </p>

                            <p>
                                <strong>Dog:</strong>
                                {{ optional($pair->dog)->name ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Dog size:</strong>
                                {{ optional(optional($pair->dog)->sizeCategory)->name ?? 'Not specified' }}
                            </p>

                            <p>
                                <strong>Active from:</strong>
                                {{ \Carbon\Carbon::parse($pair->active_from)->format('d.m.Y') }}
                            </p>

                            @if($pair->active_until)
                                <p>
                                    <strong>Active until:</strong>
                                    {{ \Carbon\Carbon::parse($pair->active_until)->format('d.m.Y') }}
                                </p>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>No pairs found</h2>
                <p>There are no agility pairs added yet.</p>
            </div>
        @endforelse
    </section>

    <script>
        const pairSearch = document.getElementById('pairSearch');
        const pairCards = document.querySelectorAll('.pair-card-js');

        pairSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            pairCards.forEach(function (card) {
                const cardText = card.dataset.search.toLowerCase();     //ņemu tekstu no meklēšanas

                if (cardText.includes(searchText)) {
                    card.style.display = '';    //ja pāris der, tad to parādam
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-layout>