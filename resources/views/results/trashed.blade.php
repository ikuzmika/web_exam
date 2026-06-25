<x-layout>
    <x-slot name="title">
        {{ __('results.trashed_title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('results.trashed_title') }}</h1>

                <p>
                    {{ __('results.trashed_description') }}
                </p>
            </div>

            <a href="{{ route('result.index') }}" class="btn btn-outline-primary">
                {{ __('common.back') }}
            </a>
        </div>
    </section>

    <section class="results-table-card">
        <div class="table-responsive">
            <table class="table results-table">
                <thead>
                <tr>
                    <th>{{ __('results.pair') }}</th>
                    <th>{{ __('results.competition') }}</th>
                    <th>{{ __('results.track') }}</th>
                    <th>{{ __('results.status') }}</th>
                    <th>{{ __('results.points') }}</th>
                    <th>{{ __('common.deleted_at') }}</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse($results as $result)
                    <tr>
                        <td>
                            {{ optional(optional(optional($result->pair)->dog)->handler)->name ?? __('common.unknown') }}
                            {{ optional(optional(optional($result->pair)->dog)->handler)->surname ?? '' }}
                            &
                            {{ optional(optional($result->pair)->dog)->name ?? __('results.unknown_dog') }}
                        </td>

                        <td>
                            {{ translate_db(optional(optional($result->track)->competition)->title) ?: __('common.not_specified') }}
                        </td>

                        <td>
                            {{ __('results.track_name', ['name' => optional($result->track)->name ?? __('common.not_specified')]) }}
                        </td>

                        <td>
                            {{ optional($result->resultStatus)->name ?? __('common.not_specified') }}
                        </td>

                        <td>
                            {{ $result->points ?? 0 }}
                        </td>

                        <td>
                            {{ $result->deleted_at?->format('d.m.Y H:i') }}
                        </td>

                        <td class="text-end">
                            @can('force-delete', \App\Models\Result::class)
                                <div class="d-flex gap-2 justify-content-end">
                                    <form method="POST" action="{{ route('result.restore', $result->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            {{ __('common.restore') }}
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('result.forceDelete', $result->id) }}"
                                          onsubmit="return confirm('{{ __('common.confirm_permanent_delete') }}')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            {{ __('common.delete') }}
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <h2>{{ __('results.no_deleted_results') }}</h2>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layout>
