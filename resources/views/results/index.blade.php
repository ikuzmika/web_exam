<x-layout>
    <x-slot name="title">
        Results
    </x-slot>

    <section class="competitions-top">
        <div class="page-header competitions-title-card">
            <div>
                <h1>Results</h1>

                <p>
                    View agility competition results for participating pairs.
                </p>
            </div>

            @can('create', App\Models\Result::class)
                <a href="{{ route('result.create') }}" class="btn btn-primary">
                    Add result
                </a>
            @endcan
        </div>

        <div class="filter-bar competitions-search-card">
            <div class="filter-field">
                <label for="resultSearch" class="form-label">
                    Search result
                </label>

                <input
                    type="text"
                    id="resultSearch"
                    class="form-control"
                    placeholder="Enter pair, dog, competition or status"
                >
            </div>
        </div>
    </section>

    <section class="results-table-card">
        <div class="table-responsive">
            <table class="table results-table">
                <thead>
                    <tr>
                        <th>Pair</th>
                        <th>Competition</th>
                        <th>Track</th>
                        <th>Status</th>
                        <th>Points</th>
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
                                {{ optional($result->track)->name }}
                                {{ optional(optional($result->track)->difficultyLevel)->name }}
                                {{ optional($result->resultStatus)->name }}
                                {{ $result->points }}
                            "
                        >
                            <td>
                                {{ optional(optional(optional($result->pair)->dog)->handler)->name ?? 'Unknown' }}
                                {{ optional(optional(optional($result->pair)->dog)->handler)->surname ?? '' }}
                                &
                                {{ optional(optional($result->pair)->dog)->name ?? 'Unknown dog' }}
                            </td>

                            <td>
                                {{ optional(optional($result->track)->competition)->title ?? 'Not specified' }}
                            </td>

                            <td>
                                Track {{ optional($result->track)->name ?? 'Not specified' }}
                            </td>

                            <td>
                                {{ optional($result->resultStatus)->name ?? 'Not specified' }}
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
                                    Details
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="resultModal{{ $result->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content result-modal">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Result details
                                        </h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>
                                            <strong>Handler:</strong>
                                            {{ optional(optional(optional($result->pair)->dog)->handler)->name ?? 'Not specified' }}
                                            {{ optional(optional(optional($result->pair)->dog)->handler)->surname ?? '' }}
                                        </p>

                                        <p>
                                            <strong>Dog:</strong>
                                            {{ optional(optional($result->pair)->dog)->name ?? 'Not specified' }}
                                        </p>

                                        <p>
                                            <strong>Competition:</strong>
                                            {{ optional(optional($result->track)->competition)->title ?? 'Not specified' }}
                                        </p>

                                        <p>
                                            <strong>Track:</strong>
                                            Track {{ optional($result->track)->name ?? 'Not specified' }}
                                        </p>

                                        <p>
                                            <strong>Difficulty level:</strong>
                                            {{ optional(optional($result->track)->difficultyLevel)->name ?? 'Not specified' }}
                                        </p>

                                        <p>
                                            <strong>Status:</strong>
                                            {{ optional($result->resultStatus)->name ?? 'Not specified' }}
                                        </p>

                                        <p>
                                            <strong>Points:</strong>
                                            {{ $result->points ?? 0 }}
                                        </p>
                                    </div>

                                    <div class="modal-footer">
                                        @can('update', $result)
                                            <a href="{{ route('result.edit', $result->id) }}" class="btn btn-outline-primary">
                                                Edit
                                            </a>
                                        @endcan

                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <h2>No results found</h2>
                                    <p>There are no results added yet.</p>
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
</x-layout>