<x-layout>
    <x-slot name="title">
        {{ __('dogs.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('dogs.trashed_title') }}</h1>

                <p>
                    {{ __('dogs.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('dog.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="dogs-grid">
        @forelse($dogs as $dog)
            <article class="dog-card">
                <h2>{{ $dog->name }}</h2>

                <p class="track-card-text">
                    <strong>{{ __('dogs.handler') }}:</strong>
                    {{ optional($dog->handler)->name ?? __('common.not_specified') }}
                    {{ optional($dog->handler)->surname ?? '' }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('dogs.dog_size') }}:</strong>
                    {{ optional($dog->sizeCategory)->name ?? __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('common.deleted_at') }}:</strong>
                    {{ $dog->deleted_at?->format('d.m.Y H:i') }}
                </p>

                @can('force-delete', \App\Models\Dog::class)

                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('dog.restore', $dog->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('common.restore') }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('dog.forceDelete', $dog->id) }}"
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
                <h2>{{ __('dogs.no_deleted_dogs') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
