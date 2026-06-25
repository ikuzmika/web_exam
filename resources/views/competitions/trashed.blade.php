<x-layout>
    <x-slot name="title">
        {{ __('competitions.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('competitions.trashed_title') }}</h1>

                <p>
                    {{ __('competitions.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('competition.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="content-list">
        @forelse($competitions as $competition)
            <article class="competition-preview-card">
                <div class="competition-preview-content">
                    <h3>{{ translate_db($competition->title) }}</h3>

                    <p>
                        <strong>{{ __('competitions.date') }}:</strong>
                        {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                    </p>

                    <p>
                        <strong>{{ __('competitions.venue') }}:</strong>
                        {{ translate_db(optional($competition->organizer)->venue) ?: __('common.not_specified') }}
                    </p>

                    <p>
                        <strong>{{ __('common.deleted_at') }}:</strong>
                        {{ $competition->deleted_at?->format('d.m.Y H:i') }}
                    </p>

                    @can('force-delete', \App\Models\Competition::class)
                        <div class="competition-preview-actions">
                            <form method="POST" action="{{ route('competition.restore', $competition->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    {{ __('common.restore') }}
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('competition.forceDelete', $competition->id) }}"
                                  onsubmit="return confirm('{{ __('common.confirm_permanent_delete') }}')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    {{ __('common.delete') }}
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>

                <div class="competition-image-placeholder">
                    {{ __('competitions.competition_image') }}
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('competitions.no_deleted_competitions') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
