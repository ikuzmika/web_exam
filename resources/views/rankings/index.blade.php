<x-layout>
    <x-slot name="title">
        Rankings
    </x-slot>

    @php
        $rankingType = request('ranking_type', 'ļatvian');

        if (!in_array($rankingType, ['latvian', 'best'])) {
            $rankingType = 'latvian';
        }

        if ($rankingType === 'best') {
            $currentRankings = $bestPairs;
            $rankingTitle = 'Latvian best pairs';
            $rankingDescription = 'This list shows the best pairs by total points. The 60% track participation rule is not used here.';
            $resultsLabel = 'Results counted';
        } else {
            $currentRankings = $latvianRankings;
            $rankingTitle = 'Latvian ranking';
            $rankingDescription = 'This list includes only pairs that completed at least 60% of tracks in the selected year with status OK or DQ.';
            $resultsLabel = 'Completed tracks';
        }
    @endphp

    <section class="page-header ranking-page-header">
        <div class = "ranking-page-header-text">
            <h1>{{$rankingTitle}}</h1>
            <p class = "ranking-description">{{$rankingDescription}}</p>
        </div>
    </section>

    <section class="filter-bar">
        <div class="mb-3 d-flex gap-2 flex-wrap">
            <a href="{{ route('rankings.index', array_merge(request()->except(['ranking_type', 'latvian_page', 'best_page']), ['ranking_type' => 'latvian'])) }}"
               class="btn {{ $rankingType === 'latvian' ? 'btn-primary' : 'btn-outline-primary' }}">
                Latvian ranking
            </a>

            <a href="{{ route('rankings.index', array_merge(request()->except(['ranking_type', 'latvian_page', 'best_page']), ['ranking_type' => 'best'])) }}"
               class="btn {{ $rankingType === 'best' ? 'btn-primary' : 'btn-outline-primary' }}">
                Latvian best pairs
            </a>
        </div>

        <form method="GET" action="{{ route('rankings.index') }}" class="row g-3">
            <input type="hidden" name="ranking_type" value="{{ $rankingType }}">

            <div class="col-md-3">
                <label for="year" class="form-label">Year</label>

                <select name="year" id="year" class="form-control">
                    <option value="">Latest year</option>

                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected((string) $selectedYear == (string) $year)>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($rankingType === 'best')

                <div class="col-md-3">
                    <label for="competition_id" class="form-label">Competition</label>

                    <select name="competition_id" id="competition_id" class="form-control">
                        <option value="">All competitions</option>

                        @foreach($competitions as $competition)
                            <option
                                value="{{ $competition->id }}" @selected(request('competition_id') == $competition->id)>
                                {{ $competition->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-2">
                <label for="size_category_id" class="form-label">Dog size</label>

                <select name="size_category_id" id="size_category_id" class="form-control">
                    <option value="">All sizes</option>

                    @foreach($sizeCategories as $sizeCategory)
                        <option
                            value="{{ $sizeCategory->id }}" @selected(request('size_category_id') == $sizeCategory->id)>
                            {{ $sizeCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($rankingType === 'best')
                <div class="col-md-2">
                    <label for="difficulty_level_id" class="form-label">Difficulty</label>

                    <select name="difficulty_level_id" id="difficulty_level_id" class="form-control">
                        <option value="">All levels</option>

                        @foreach($difficultyLevels as $difficultyLevel)
                            <option
                                value="{{ $difficultyLevel->id }}" @selected(request('difficulty_level_id') == $difficultyLevel->id)>
                                {{ $difficultyLevel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    Filter
                </button>

                <a href="{{ route('rankings.index', ['ranking_type' => $rankingType]) }}"
                   class="btn btn-outline-primary">
                    Reset
                </a>
            </div>
        </form>
    </section>

    @if($rankingType === 'latvian')
        <section class="ranking-info mt-3">
            <div class="alert alert-info">
                In the selected year there are <strong>{{ $totalTracks }}</strong> tracks.
                To be included in the Latvian ranking, a pair must complete at least
                <strong>{{ $minimumRuns }}</strong> tracks with status <strong>OK</strong> or <strong>DQ</strong>.
            </div>
        </section>
    @endif

    <section class="content-list">
        @forelse($currentRankings as $ranking)
            <article class="list-card">
                <div class="list-card-content">
                    <h2>
                        #{{ $currentRankings->firstItem() + $loop->index }}
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
                        <strong>{{$resultsLabel}}</strong>
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

                @if($rankingType === 'latvian')
                    <p>
                        There are no pairs that match the selected filters and the 60% participation rule.
                    </p>
                @else
                    <p>
                        There are no results for selected filters.
                    </p>
                @endif
            </div>
        @endforelse
    </section>

    <div class="mt-3">
        {{ $currentRankings->links('pagination::bootstrap-5') }}
    </div>
</x-layout>
