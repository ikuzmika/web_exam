<x-layout>
    <x-slot name="title">
        {{ __('handlers.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('handlers.trashed_title') }}</h1>

                <p>
                    {{ __('handlers.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('handler.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="handlers-grid">
        @forelse($handlers as $handler)
            <article class="handler-card">
                <h2>
                    {{ $handler->name }}
                    {{ $handler->surname }}
                </h2>

                <p class="track-card-text">
                    <strong>{{ __('handlers.email') }}:</strong>
                    {{ $handler->email ?? __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('handlers.contact_number') }}:</strong>
                    {{ $handler->contact_number ?? __('common.not_specified') }}
                </p>

                <p class="track-card-text">
                    <strong>{{ __('common.deleted_at') }}:</strong>
                    {{ $handler->deleted_at?->format('d.m.Y H:i') }}
                </p>

                @can('force-delete', \App\Models\Handler::class)
                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('handler.restore', $handler->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('common.restore') }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('handler.forceDelete', $handler->id) }}"
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
                <h2>{{ __('handlers.no_deleted_handlers') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
