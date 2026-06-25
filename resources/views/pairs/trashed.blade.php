<x-layout>
    <x-slot name="title">
        {{ __('pairs.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('pairs.trashed_title') }}</h1>

                <p>
                    {{ __('pairs.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('pair.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="pairs-grid">
        @forelse($pairs as $pair)
            <article class="pair-card">
                <h2>
                    {{ optional(optional($pair->dog)->handler)->name ?? __('common.unknown') }}
                    {{ optional(optional($pair->dog)->handler)->surname ?? '' }}
                    &
                    {{ optional($pair->dog)->name ?? __('pairs.unknown_dog') }}
                </h2>

                <p class="track-card-text">
                    <strong>{{ __('pairs.dog_size') }}:</strong>
                    {{ optional(optional($pair->dog)->sizeCategory)->name ?? __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('pairs.active_from') }}:</strong>
                    {{ $pair->active_from ? \Carbon\Carbon::parse($pair->active_from)->format('d.m.Y') : __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('common.deleted_at') }}:</strong>
                    {{ $pair->deleted_at?->format('d.m.Y H:i') }}
                </p>

                @can('force-delete', \App\Models\Pair::class)
                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('pair.restore', $pair->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('common.restore') }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('pair.forceDelete', $pair->id) }}"
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
                <h2>{{ __('pairs.no_deleted_pairs') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
