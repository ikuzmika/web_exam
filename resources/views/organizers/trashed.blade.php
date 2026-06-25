<x-layout>
    <x-slot name="title">
        {{ __('organizers.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('organizers.trashed_title') }}</h1>

                <p>
                    {{ __('organizers.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('organizer.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="organizers-grid">
        @forelse($organizers as $organizer)
            <article class="organizer-card">
                <h2>{{ $organizer->name }}</h2>

                <p class="organizer-card-text">
                    {{ $organizer->venue ?? __('organizers.venue_not_specified') }}
                </p>

                <p class="organizer-card-text">
                    <strong>{{ __('common.deleted_at') }}:</strong>
                    {{ $organizer->deleted_at?->format('d.m.Y H:i') }}
                </p>

                @can('force-delete', \App\Models\Organizer::class)
                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('organizer.restore', $organizer->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('common.restore') }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('organizer.forceDelete', $organizer->id) }}"
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
                <h2>{{ __('organizers.no_deleted_organizers') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
