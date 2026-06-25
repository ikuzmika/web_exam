<x-layout>
    <x-slot name="title">
        {{ __('sponsors.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('sponsors.trashed_title') }}</h1>

                <p>
                    {{ __('sponsors.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('sponsor.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="sponsors-grid">
        @forelse($sponsors as $sponsor)
            <article class="sponsor-card">
                <h2>{{ $sponsor->name }}</h2>

                <p class="sponsor-card-text">
                    {{ $sponsor->email ?? __('sponsors.email_not_specified') }}
                </p>

                <p class="sponsor-card-text">
                    <strong>{{ __('common.deleted_at') }}:</strong>
                    {{ $sponsor->deleted_at?->format('d.m.Y H:i') }}
                </p>

                @can('force-delete', App\Models\Sponsor::class)
                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('sponsor.restore', $sponsor->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                {{ __('common.restore') }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('sponsor.forceDelete', $sponsor->id) }}"
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
                <h2>{{ __('sponsors.no_deleted_sponsors') }}</h2>
            </div>
        @endforelse
    </section>
</x-layout>
