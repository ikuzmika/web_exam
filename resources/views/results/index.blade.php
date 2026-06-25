<x-layout>
    <x-slot name="title">
        {{ __('results.title') }}
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>{{ __('results.title') }}</h1>

                <p>
                    {{ __('results.index_description') }}
                </p>
            </div>

            <div class="d-flex gap-2">
                @can('create', App\Models\Result::class)
                    <a href="{{ route('result.create') }}" class="btn btn-primary">
                        {{ __('results.add_result') }}
                    </a>
                @endcan

                @can('viewTrashed', App\Models\Result::class)
                    <a href="{{ route('result.trashed') }}" class="btn btn-outline-danger">
                        {{ __('results.deleted_results') }}
                    </a>
                @endcan
            </div>
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="resultSearch" class="form-label">
                    {{ __('results.search_result') }}
                </label>

                <input
                    type="text"
                    id="resultSearch"
                    class="form-control"
                    placeholder="{{ __('results.search_placeholder') }}"
                >
            </div>
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
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse($results as $result)
                    <tr
                        class="result-row-js"
                        data-search="
                                {{ optional(optional(optional($result->pair)->dog)->handler)->name }}
                                {{ optional(optional(optional($result->pair)->dog)->handler)->surname }}
                                {{ optional(optional($result->pair)->dog)->name }}
                                {{ optional(optional($result->track)->competition)->title }}
                                {{ translate_db(optional(optional($result->track)->competition)->title) }}
                                {{ optional($result->track)->name }}
                                {{ optional(optional($result->track)->difficultyLevel)->name }}
                                {{ translate_db(optional(optional($result->track)->difficultyLevel)->name) }}
                                {{ optional($result->resultStatus)->name }}
                                {{ $result->points }}
                            "
                    >
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

                        <td class="text-end">
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#resultModal{{ $result->id }}"
                            >
                                {{ __('common.view_details') }}
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="resultModal{{ $result->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content result-modal">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        {{ __('results.result_details') }}
                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>
                                        <strong>{{ __('results.handler') }}:</strong>
                                        {{ optional(optional(optional($result->pair)->dog)->handler)->name ?? __('common.not_specified') }}
                                        {{ optional(optional(optional($result->pair)->dog)->handler)->surname ?? '' }}
                                    </p>

                                    <p>
                                        <strong>{{ __('results.dog') }}:</strong>
                                        {{ optional(optional($result->pair)->dog)->name ?? __('common.not_specified') }}
                                    </p>

                                    <p>
                                        <strong>{{ __('results.competition') }}:</strong>
                                        {{ translate_db(optional(optional($result->track)->competition)->title) ?: __('common.not_specified') }}
                                    </p>

                                    <p>
                                        <strong>{{ __('results.track') }}:</strong>
                                        {{ __('results.track_name', ['name' => optional($result->track)->name ?? __('common.not_specified')]) }}
                                    </p>

                                    <p>
                                        <strong>{{ __('results.difficulty_level') }}:</strong>
                                        {{ translate_db(optional(optional($result->track)->difficultyLevel)->name) ?: __('common.not_specified') }}
                                    </p>

                                    <p>
                                        <strong>{{ __('results.status') }}:</strong>
                                        {{ optional($result->resultStatus)->name ?? __('common.not_specified') }}
                                    </p>

                                    <p>
                                        <strong>{{ __('results.points') }}:</strong>
                                        {{ $result->points ?? 0 }}
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    @can('update', $result)
                                        <a href="{{ route('result.edit', $result->id) }}" class="btn btn-outline-primary">
                                            {{ __('common.edit') }}
                                        </a>
                                    @endcan

                                    @can('delete', $result)
                                        <form method="POST"
                                              action="{{ route('result.destroy', $result->id) }}"
                                              onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
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
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <h2>{{ __('results.no_results') }}</h2>
                                <p>{{ __('results.no_results_description') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <script>
        const resultSearch = document.getElementById('resultSearch');
        const resultRows = document.querySelectorAll('.result-row-js');

        resultSearch.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            resultRows.forEach(function (row) {
                const rowText = row.dataset.search.toLowerCase();

                if (rowText.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    @if($results->hasPages())
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div>
                @if($results->onFirstPage())
                    <span class="btn btn-outline-primary disabled">
                    {{ __('pagination.previous') }}
                </span>
                @else
                    <a href="{{ $results->previousPageUrl() }}" class="btn btn-outline-primary">
                        {{ __('pagination.previous') }}
                    </a>
                @endif
            </div>

            <div class="text-muted">
                {{ __('pagination.page_info', [
                    'current' => $results->currentPage(),
                    'last' => $results->lastPage(),
                ]) }}
            </div>

            <div>
                @if($results->hasMorePages())
                    <a href="{{ $results->nextPageUrl() }}" class="btn btn-outline-primary">
                        {{ __('pagination.next') }}
                    </a>
                @else
                    <span class="btn btn-outline-primary disabled">
                    {{ __('pagination.next') }}
                </span>
                @endif
            </div>
        </div>
    @endif
</x-layout>
