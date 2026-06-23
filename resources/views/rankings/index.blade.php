<x-layout>
    <x-slot name="title">
        Rankings
    </x-slot>

    <section class="page-header">
        <div>
            <h1>Latvian ranking</h1>
            <p>View agility pairs ranking by year, competition, dog size and difficulty level.</p>
        </div>
    </section>

    <section class="filter-bar">
        <form method="GET" action="{{ route('rankings.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="year" class="form-label">Year</label>

                <select name="year" id="year" class="form-control">
                    <option value="">All years</option>

                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected(request('year') == $year)>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="competition_id" class="form-label">Competition</label>

                <select name="competition_id" id="competition_id" class="form-control">
                    <option value="">All competitions</option>

                    @foreach($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected(request('competition_id') == $competition->id)>
                            {{ $competition->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="size_category_id" class="form-label">Dog size</label>

                <select name="size_category_id" id="size_category_id" class="form-control">
                    <option value="">All sizes</option>

                    @foreach($sizeCategories as $sizeCategory)
                        <option value="{{ $sizeCategory->id }}" @selected(request('size_category_id') == $sizeCategory->id)>
                            {{ $sizeCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="difficulty_level_id" class="form-label">Difficulty</label>

                <select name="difficulty_level_id" id="difficulty_level_id" class="form-control">
                    <option value="">All levels</option>

                    @foreach($difficultyLevels as $difficultyLevel)
                        <option value="{{ $difficultyLevel->id }}" @selected(request('difficulty_level_id') == $difficultyLevel->id)>
                            {{ $difficultyLevel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    Filter
                </button>

                <a href="{{ route('rankings.index') }}" class="btn btn-outline-primary">
                    Reset
                </a>
            </div>
        </form>
    </section>

    <section class="content-list">
        @forelse($rankings as $ranking)
            <article class="list-card">
                <div class="list-card-content">
                    <h2>
                        #{{ $rankings->firstItem() + $loop->index }}
                        {{ optional($ranking->pair->dog->handler)->name }}
                        {{ optional($ranking->pair->dog->handler)->surname }}
                        &
                        {{ optional($ranking->pair->dog)->name }}
                    </h2>

                    <p>
                        <strong>Total points:</strong>
                        {{ $ranking->total_points ?? 0 }}
                    </p>

                    <p>
                        <strong>Results counted:</strong>
                        {{ $ranking->result_count }}
                    </p>

                    <p>
                        <strong>Dog size:</strong>
                        {{ optional($ranking->pair->dog->sizeCategory)->name ?? 'Not specified' }}
                    </p>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>No ranking results found</h2>
                <p>There are no results for selected filters.</p>
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $rankings->links('pagination::bootstrap-5') }}
    </div>
</x-layout>