<x-layout>
    <x-slot name="title">
        {{ __('sponsors.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('sponsors.title') }}</h1>

                <p>
                    {{ __('sponsors.index_description') }}
                </p>
            </div>

            @can('create', App\Models\Sponsor::class)
                <a href="{{ route('sponsor.create') }}" class="btn btn-primary">
                    {{ __('sponsors.add_sponsor') }}
                </a>
            @endcan
            @can('viewTrashed', App\Models\Sponsor::class)
                <a href="{{ route('sponsor.trashed') }}" class="btn btn-outline-danger">
                    {{ __('sponsors.deleted_sponsors') }}
                </a>
            @endcan
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="sponsorSearch" class="form-label">
                    {{ __('sponsors.search_sponsor') }}
                </label>

                <input
                    type="text"
                    id="sponsorSearch"
                    class="form-control"
                    placeholder="{{ __('sponsors.search_placeholder') }}"
                >
            </div>
        </div>
    </section>

    <section class="sponsors-grid">
        @forelse($sponsors as $sponsor)
            <article
                class="sponsor-card sponsor-card-js"
                data-search="
                    {{ $sponsor->name }}
                    {{ $sponsor->email }}
                    {{ $sponsor->description }}
                    @foreach($sponsor->organizers as $organizer)
                        {{ $organizer->name }}
                    @endforeach
                "
            >
                <h2>
                    {{ $sponsor->name }}
                </h2>

                <p class="sponsor-card-text">
                    {{ $sponsor->email ?? __('sponsors.email_not_specified') }}
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#sponsorModal{{ $sponsor->id }}"
                >
                    {{ __('common.view_details') }}
                </button>
            </article>

            <div class="modal fade" id="sponsorModal{{ $sponsor->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content sponsor-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $sponsor->name }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>{{ __('sponsors.sponsor') }}:</strong>
                                {{ $sponsor->name }}
                            </p>

                            <p>
                                <strong>{{ __('sponsors.email') }}:</strong>
                                {{ $sponsor->email ?? __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('sponsors.description') }}:</strong>
                                {{ translate_db($sponsor->description) ?: __('common.not_specified') }}
                            </p>

                            <div>
                                <strong>{{ __('sponsors.organizers') }}:</strong>

                                @forelse($sponsor->organizers as $organizer)
                                    <div class="mt-2">
                                        <div>
                                            {{ $organizer->name }}
                                        </div>

                                        <div class="text-muted">
                                            {{ __('sponsors.contribution_type') }}:
                                            {{ translate_db($organizer->pivot?->contribution_type) ?: __('common.not_specified') }}
                                        </div>

                                        <div class="text-muted">
                                            {{ __('sponsors.contribution_amount') }}:
                                            @if($organizer->pivot?->contribution_amount !== null)
                                                {{ number_format($organizer->pivot->contribution_amount, 2) }}
                                            @else
                                                {{ __('common.not_specified') }}
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted">
                                        {{ __('common.not_specified') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="modal-footer">
                            @can('update', $sponsor)
                                <a href="{{ route('sponsor.edit', $sponsor->id) }}" class="btn btn-outline-primary">
                                    {{ __('common.edit') }}
                                </a>
                            @endcan

                            @can('delete', $sponsor)
                                <form method="POST"
                                      action="{{ route('sponsor.destroy', $sponsor->id) }}"
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
                <h2>{{ __('sponsors.no_sponsors') }}</h2>
                <p>{{ __('sponsors.no_sponsors_description') }}</p>
            </div>
        @endforelse
    </section>

    <script>
        const sponsorSearch = document.getElementById('sponsorSearch');
        const sponsorCards = document.querySelectorAll('.sponsor-card-js');

        sponsorSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            sponsorCards.forEach(function (card) {
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
