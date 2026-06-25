<x-layout>
    <x-slot name="title">
        {{ __('tracks.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('tracks.trashed_title') }}</h1>

                <p>
                    {{ __('tracks.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('track.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="tracks-grid">
        @forelse($tracks as $track)
            <article class="track-card">
                <h2>
                    {{ __('tracks.track_name', ['name' => $track->name]) }}
                </h2>

                <p class="track-card-text">
                    {{ translate_db(optional($track->competition)->title) ?: __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('tracks.difficulty_level') }}:</strong>
                    {{ translate_db(optional($track->difficultyLevel)->name) ?: __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('common.deleted_at') }}:</strong>
                    {{ $track->deleted_at?->format('d.m.Y H:i') }}
                </p>

                @can('force-delete', \App\Models\Track::class)
                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('track.restore', $track->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('common.restore') }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('track.forceDelete', $track->id) }}"
                              onsubmit="return confirm('{{ __('common.confirm_permanent_delete') }}')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                {{ __('common.delete') }}
                            </button>
                        </form>
                    </div>
                @endcan
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('tracks.no_deleted_tracks') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
