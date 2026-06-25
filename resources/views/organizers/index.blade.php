<x-layout>
    <x-slot name="title">
        {{ __('organizers.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('organizers.title') }}</h1>

                <p>
                    {{ __('organizers.index_description') }}
                </p>
            </div>

            <div class="d-flex gap-2">
                @can('create', App\Models\Organizer::class)
                    <a href="{{ route('organizer.create') }}" class="btn btn-primary">
                        {{ __('organizers.add_organizer') }}
                    </a>
                @endcan

                @can('viewTrashed', App\Models\Organizer::class)
                    <a href="{{ route('organizer.trashed') }}" class="btn btn-outline-danger">
                        {{ __('organizers.deleted_organizers') }}
                    </a>
                @endcan
            </div>

        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="organizerSearch" class="form-label">
                    {{ __('organizers.search_organizer') }}
                </label>

                <input
                    type="text"
                    id="organizerSearch"
                    class="form-control"
                    placeholder="{{ __('organizers.search_placeholder') }}"
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
                    {{ $organizer->venue ?? __('organizers.venue_not_specified') }}
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#organizerModal{{ $organizer->id }}"
                >
                    {{ __('common.view_details') }}
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
                                <strong>{{ __('organizers.organizer') }}:</strong>
                                {{ $organizer->name }}
                            </p>

                            <p>
                                <strong>{{ __('organizers.venue') }}:</strong>
                                {{ $organizer->venue ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('organizers.contact_person') }}:</strong>
                                {{ $organizer->contact_person ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('organizers.email') }}:</strong>
                                {{ $organizer->email ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('organizers.contact_number') }}:</strong>
                                {{ $organizer->contact_number ?? __('common.not_specified') }}
                            </p>

                            <div><strong>{{ __('organizers.sponsors') }}
                                    :</strong> @forelse($organizer->sponsors as $sponsor)
                                    <div class="mt-2">
                                        <div> {{ $sponsor->name }} </div>
                                        <div class="text-muted"> {{ __('organizers.contribution_type') }}
                                            : {{ translate_db($sponsor->pivot?->contribution_type) ?: __('common.not_specified') }}
                                        </div>
                                        <div class="text-muted"> {{ __('organizers.contribution_amount') }}
                                            : @if($sponsor->pivot?->contribution_amount !== null)
                                                {{ number_format($sponsor->pivot->contribution_amount, 2) }}
                                            @else
                                                {{ __('common.not_specified') }}
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted"> {{ __('common.not_specified') }} </div>
                                @endforelse </div>
                        </div>

                        <div class="modal-footer">
                            @can('update', $organizer)
                                <a href="{{ route('organizer.edit', $organizer->id) }}" class="btn btn-outline-primary">
                                    {{ __('common.edit') }}
                                </a>
                            @endcan

                            @can('delete', $organizer)
                                <form method="POST"
                                      action="{{ route('organizer.destroy', $organizer->id) }}"
                                      onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        {{ __('common.delete') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h2>{{ __('organizers.no_organizers') }}</h2>
                <p>{{ __('organizers.no_organizers_description') }}</p>
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
