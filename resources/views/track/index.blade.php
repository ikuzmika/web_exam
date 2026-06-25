<x-layout>
    <x-slot name="title">
        {{ __('tracks.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('tracks.title') }}</h1>

                <p>
                    {{ __('tracks.page_description') }}
                </p>
            </div>

            <div class="d-flex gap-2">
                @can('create', App\Models\Track::class)
                    <a href="{{ route('track.create') }}" class="btn btn-primary">
                        {{ __('tracks.add_track') }}
                    </a>
                @endcan

                @can('viewTrashed', App\Models\Track::class)
                    <a href="{{ route('track.trashed') }}" class="btn btn-outline-danger">
                        {{ __('tracks.deleted_tracks') }}
                    </a>
                @endcan
            </div>
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="trackSearch" class="form-label">
                    {{ __('tracks.search_track') }}
                </label>

                <input
                    type="text"
                    id="trackSearch"
                    class="form-control"
                    placeholder="{{ __('tracks.search_placeholder') }}"
                >
            </div>
        </div>
    </section>

    <section class="tracks-grid">
        @forelse($tracks as $track)
            <article
                class="track-card track-card-js"
                data-search="
                    {{ $track->name }}
                    {{ optional($track->competition)->title }}
                    {{ optional($track->difficultyLevel)->name }}
                "
            >
                <h2>
                    {{ __('tracks.track_name', ['name' => $track->name]) }}
                </h2>

                <p class="track-card-text">
                    {{ translate_db(optional($track->competition)->title) ?: __('tracks.competition_not_specified') }}
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#trackModal{{ $track->id }}"
                >
                    {{ __('common.view_details') }}
                </button>
            </article>

            <div class="modal fade" id="trackModal{{ $track->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content track-modal">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $track->name }}
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>{{ __('tracks.track') }}:</strong>
                                {{ $track->name }}
                            </p>

                            <p>
                                <strong>{{ __('tracks.competition') }}:</strong>
                                {{ translate_db(optional($track->competition)->title) ?: __('common.not_specified') }}
                            </p>

                            <p>
                                <strong>{{ __('tracks.competition_date') }}:</strong>
                                @if(optional($track->competition)->date)
                                    {{ \Carbon\Carbon::parse($track->competition->date)->format('d.m.Y') }}
                                @else
                                    {{ __('common.not_specified') }}
                                @endif
                            </p>

                            <p>
                                <strong>{{ __('tracks.difficulty_level') }}:</strong>
                                {{ translate_db(optional($track->difficultyLevel)->name) ?: __('common.not_specified') }}
                            </p>

                            @php
                                $trackPhoto = $track->schemePhotos->first();
                            @endphp

                            @if($trackPhoto)
                                <div class="mt-3">
                                    <strong>{{ __('tracks.track_photo') }}:</strong>

                                    <div class="photo-show-image-wrapper mt-2">
                                        <img
                                            src="{{ asset('storage/' . $trackPhoto->file_path) }}"
                                            alt="{{ $trackPhoto->title ?? __('tracks.track_photo') }}"
                                            class="photo-show-image"
                                        >
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            @can('update', $track)
                                <a href="{{ route('track.edit', $track->id) }}" class="btn btn-outline-primary">
                                    {{ __('common.edit') }}
                                </a>
                            @endcan

                            @can('delete', $track)
                                <form method="POST"
                                      action="{{ route('track.destroy', $track->id) }}"
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
                <h2>{{ __('tracks.no_tracks') }}</h2>
                <p>{{ __('tracks.no_tracks_description') }}</p>
            </div>
        @endforelse
    </section>

    <script>
        const trackSearch = document.getElementById('trackSearch');
        const trackCards = document.querySelectorAll('.track-card-js');

        trackSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            trackCards.forEach(function (card) {
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
