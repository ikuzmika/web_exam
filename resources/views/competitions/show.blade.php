<x-layout>
    <x-slot name="title">
        {{ __('competitions.show_title') }}
    </x-slot>

    <section class="page-header">
        <div>
            <h1>{{ translate_db($competition->title) }}</h1>

            <p>
                {{ __('competitions.show_title') }}
            </p>
        </div>

        <div class="d-flex gap-2">
            @can('update', $competition)
                <a href="{{ route('competition.edit', $competition->id) }}" class="btn btn-outline-primary">
                    {{ __('common.edit') }}
                </a>
            @endcan

            <a href="{{ route('competition.index') }}" class="btn btn-outline-primary">
                {{ __('competitions.back_to_competitions') }}
            </a>
        </div>
    </section>

    @php
        $competitionPhoto = $competition->photo
            ->where('title', 'Competition card photo')
            ->first();

        if (!$competitionPhoto) {
            $competitionPhoto = $competition->photo->first();
        }
    @endphp

    <section class="results-table-card mb-4">
        @if($competitionPhoto)
            <div class="photo-show-image-wrapper mb-4">
                <img
                    src="{{ asset('storage/' . $competitionPhoto->file_path) }}"
                    alt="{{ __('competitions.competition_image') }}"
                    class="photo-show-image"
                >
            </div>
        @endif

        <p>
            <strong>{{ __('competitions.date') }}:</strong>
            {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
        </p>

        <p>
            <strong>{{ __('competitions.organizer') }}:</strong>
            {{ translate_db(optional($competition->organizer)->name) ?: __('common.not_specified') }}
        </p>

        <p>
            <strong>{{ __('competitions.venue') }}:</strong>
            {{ translate_db(optional($competition->organizer)->venue) ?: __('common.not_specified') }}
        </p>

        <p>
            <strong>{{__('competitions.judge')}}:</strong>
            {{ optional($competition->judge)->name ?? __('common.not_specified') }}
            {{ optional($competition->judge)->surname ?? '' }}
        </p>
    </section>

    <section class="results-table-card">
        <h2 class="mb-3">
            {{ __('competitions.tracks') }}
        </h2>

        @forelse($competition->track as $track)
            <div class="list-card competition-track-card mb-2">
                <div class="list-card-content">
                    <h2>
                        {{ __('tracks.track_name', ['name' => $track->name]) }}
                    </h2>

                    <p>
                        <strong>{{ __('tracks.difficulty_level') }}:</strong>
                        {{ translate_db(optional($track->difficultyLevel)->name) ?: __('common.not_specified') }}
                    </p>
                </div>

                <div class="list-card-actions">
                    <button
                        type="button"
                        class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#trackModal{{ $track->id }}"
                    >
                        {{ __('common.view_details') }}
                    </button>
                </div>
            </div>

            <div
                class="modal fade"
                id="trackModal{{ $track->id }}"
                tabindex="-1"
                aria-labelledby="trackModalLabel{{ $track->id }}"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content track-modal">
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="trackModalLabel{{ $track->id }}">
                                {{ __('tracks.track_name', ['name' => $track->name]) }}
                            </h2>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="{{ __('common.close') }}"
                            ></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                <strong>{{ __('tracks.competition') }}:</strong>
                                {{ translate_db($competition->title) }}
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
                            @else
                                <p class="text-muted mt-3">
                                    {{ __('tracks.no_track_photo') }}
                                </p>
                            @endif
                        </div>

                        <div class="modal-footer">
                            @can('update', $track)
                                <a href="{{ route('track.edit', $track->id) }}" class="btn btn-outline-primary">
                                    {{ __('common.edit') }}
                                </a>
                            @endcan

                            @can('delete', $track)
                                <form
                                    method="POST"
                                    action="{{ route('track.destroy', $track->id) }}"
                                    onsubmit="return confirm('{{ __('common.confirm_delete') }}')"
                                >
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
</x-layout>
