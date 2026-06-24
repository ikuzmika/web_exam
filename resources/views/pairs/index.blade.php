<x-layout>
    <x-slot name="title">
        {{ __('pairs.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('pairs.agility_pairs') }}</h1>
                <p>{{ __('pairs.index_description') }}</p>
            </div>

            @can('create', App\Models\Pair::class)
                <a href="{{ route('pair.create') }}" class="btn btn-primary">
                    {{ __('pairs.add_pair') }}
                </a>
            @endcan
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="pairSearch" class="form-label">
                    {{ __('pairs.search_pair') }}
                </label>

                <input
                    type="text"
                    id="pairSearch"
                    class="form-control"
                    placeholder="{{ __('pairs.search_placeholder') }}"
                >
            </div>
        </div>
    </section>

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
                    {{ optional(optional($pair->dog)->handler)->name ?? __('common.unknown') }}
                    {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                    &
                    {{ optional($pair->dog)->name ?? __('pairs.unknown_dog') }}
                </h2>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#pairModal{{ $pair->id }}"
                >
                    {{ __('common.view_details') }}
                </button>
            </article>

            <div class="modal fade" id="pairModal{{ $pair->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content pair-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ optional(optional($pair->dog)->handler)->name ?? __('common.unknown') }}
                                {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                                &
                                {{ optional($pair->dog)->name ?? __('pairs.unknown_dog') }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>{{ __('pairs.handler') }}:</strong>
                                {{ optional(optional($pair->dog)->handler)->name ?? __('common.not_specified') }}
                                {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                            </p>

                            <p>
                                <strong>{{ __('pairs.dog') }}:</strong>
                                {{ optional($pair->dog)->name ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('pairs.dog_size') }}:</strong>
                                @if (optional(optional($pair->dog)->sizeCategory)->name)
                                    {{ translate_db(optional(optional($pair->dog)->sizeCategory)->name) }}
                                @else
                                    {{ __('common.not_specified') }}
                                @endif
                            </p>

                            @if($pair->active_from)
                                <p>
                                    <strong>{{ __('pairs.active_from') }}:</strong>
                                    {{ \Carbon\Carbon::parse($pair->active_from)->format('d.m.Y') }}
                                </p>
                            @endif

                            @if($pair->active_until)
                                <p>
                                    <strong>{{ __('pairs.active_until') }}:</strong>
                                    {{ \Carbon\Carbon::parse($pair->active_until)->format('d.m.Y') }}
                                </p>
                            @endif
                        </div>

                        <div class="modal-footer">
                            @can('update', $pair)
                                <a href="{{ route('pair.edit', $pair->id) }}" class="btn btn-outline-primary">
                                    {{ __('common.edit') }}
                                </a>
                            @endcan
                            
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                {{ __('common.close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>{{ __('pairs.no_pairs') }}</h2>
                <p>{{ __('pairs.no_pairs_description') }}</p>
            </div>
        @endforelse
    </section>

    <script>
        const pairSearch = document.getElementById('pairSearch');
        const pairCards = document.querySelectorAll('.pair-card-js');

        pairSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            pairCards.forEach(function (card) {
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
