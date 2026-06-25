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
            <strong>Judge:</strong>
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
                        Track {{ $track->name }}
                    </h2>

                    <p>
                        <strong>{{ __('tracks.difficulty_level') }}:</strong>
                        {{ translate_db(optional($track->difficultyLevel)->name) ?: __('common.not_specified') }}
                    </p>
                </div>

                <div class="list-card-actions">
                    <a href="{{ route('track.show', $track->id) }}" class="btn btn-outline-primary btn-sm">
                        {{ __('common.view_details') }}
                    </a>
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