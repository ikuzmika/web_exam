<x-layout>
    <x-slot name="title">
        {{ __('rankings.title') }}
    </x-slot>
    @php
        $rankingType = request('ranking_type', 'latvian');

        if (!in_array($rankingType, ['latvian', 'best'])) {
            $rankingType = 'latvian';
        }

        if ($rankingType === 'best') {
            $currentRankings = $bestPairs;
            $rankingTitle = __('rankings.latvian_best_pairs');
            $rankingDescription = __('rankings.best_pairs_description');
            $resultsLabel = __('rankings.results_counted');
        } else {
            $currentRankings = $latvianRankings;
            $rankingTitle = __('rankings.latvian_ranking');
            $rankingDescription = __('rankings.latvian_ranking_description');
            $resultsLabel = __('rankings.completed_tracks');
        }
    @endphp

    <section class="page-header ranking-page-header">
        <div class="ranking-page-header-text">
            <h1>{{ $rankingTitle }}</h1>
            <p class="ranking-description">{{ $rankingDescription }}</p>
        </div>
    </section>

    <section class="filter-bar">
        <div class="mb-3 d-flex gap-2 flex-wrap">
            <a href="{{ route('rankings.index', array_merge(request()->except(['ranking_type', 'latvian_page', 'best_page']), ['ranking_type' => 'latvian'])) }}"
               class="btn {{ $rankingType === 'latvian' ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ __('rankings.latvian_ranking') }}
            </a>

            <a href="{{ route('rankings.index', array_merge(request()->except(['ranking_type', 'latvian_page', 'best_page']), ['ranking_type' => 'best'])) }}"
               class="btn {{ $rankingType === 'best' ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ __('rankings.latvian_best_pairs') }}
            </a>
        </div>

        <form method="GET" action="{{ route('rankings.index') }}" class="row g-3">
            <input type="hidden" name="ranking_type" value="{{ $rankingType }}">

            <div class="col-md-3">
                <label for="year" class="form-label">
                    {{ __('rankings.year') }}
                </label>

                <select name="year" id="year" class="form-control">
                    <option value="">
                        {{ __('rankings.latest_year') }}
                    </option>

                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected((string) $selectedYear == (string) $year)>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($rankingType === 'best')
                <div class="col-md-3">
                    <label for="competition_id" class="form-label">
                        {{ __('rankings.competition') }}
                    </label>

                    <select name="competition_id" id="competition_id" class="form-control">
                        <option value="">
                            {{ __('rankings.all_competitions') }}
                        </option>

                        @foreach($competitions as $competition)
                            <option value="{{ $competition->id }}"
                                @selected(request('competition_id') == $competition->id)>
                                {{ translate_db($competition->title) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-2">
                <label for="size_category_id" class="form-label">
                    {{ __('rankings.dog_size') }}
                </label>

                <select name="size_category_id" id="size_category_id" class="form-control">
                    <option value="">
                        {{ __('rankings.all_sizes') }}
                    </option>

                    @foreach($sizeCategories as $sizeCategory)
                        <option
                            value="{{ $sizeCategory->id }}"
                            @selected(request('size_category_id') == $sizeCategory->id)>
                            {{ $sizeCategory->name }} </option>
                    @endforeach
                </select>
            </div>

            @if ($rankingType === 'best')
                <div class="col-md-2">
                    <label for="difficulty_level_id" class="form-label">
                        {{ __('rankings.difficulty') }}
                    </label>

                    <select name="difficulty_level_id" id="difficulty_level_id" class="form-control">
                        <option value="">
                            {{ __('rankings.all_levels') }}
                        </option>

                        @foreach($difficultyLevels as $difficultyLevel)
                            <option value="{{ $difficultyLevel->id }}"
                                @selected(request('difficulty_level_id') == $difficultyLevel->id)>
                                {{ translate_db($difficultyLevel->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('common.filter') }}
                </button>

                <a href="{{ route('rankings.index', ['ranking_type' => $rankingType]) }}"
                   class="btn btn-outline-primary">
                    {{ __('common.reset') }}
                </a>
            </div>
        </form>
    </section>

    @if($rankingType === 'latvian')
        <section class="ranking-info mt-3">
            <div class="alert alert-info">
                {!! __('rankings.total_tracks_message', [
                    'total' => '<strong>' . $totalTracks . '</strong>',
                    'minimum' => '<strong>' . $minimumRuns . '</strong>',
                ]) !!}
            </div>
        </section>
    @endif

    <section class="content-list">
        @forelse($currentRankings as $ranking)
            <article class="list-card">
                <div class="list-card-content">
                    <h2>
                        #{{ $currentRankings->firstItem() + $loop->index }}

                        {{ $ranking->pair?->dog?->handler?->name ?? __('common.unknown') }}
                        {{ $ranking->pair?->dog?->handler?->surname ?? '' }}

                        &

                        {{ $ranking->pair?->dog?->name ?? __('pairs.unknown_dog') }}
                    </h2>

                    <p>
                        <strong>{{ __('rankings.total_points') }}:</strong>
                        {{ $ranking->total_points ?? 0 }}
                    </p>

                    <p>
                        <strong>{{ $resultsLabel }}:</strong>
                        {{ $ranking->result_count }}
                    </p>

                    <p>
                        <strong>{{ __('rankings.dog_size_label') }}:</strong>
                        {{ $ranking->pair?->dog?->sizeCategory?->name ?? __('common.not_specified') }}
                    </p>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h2>{{ __('rankings.no_ranking_results') }}</h2>

                @if($rankingType === 'latvian')
                    <p>
                        {{ __('rankings.no_latvian_ranking_results_description') }}
                    </p>
                @else
                    <p>
                        {{ __('rankings.no_best_pairs_results_description') }}
                    </p>
                @endif
            </div>
        @endforelse
    </section>

    @if ($currentRankings->hasPages())
        <div class="mt-3 d-flex justify-content-between align-items-center">
            <div>
                @if ($currentRankings->onFirstPage())
                    <span class="btn btn-outline-primary disabled">
                    {{ __('pagination.previous') }}
                </span>
                @else
                    <a href="{{ $currentRankings->previousPageUrl() }}" class="btn btn-outline-primary">
                        {{ __('pagination.previous') }}
                    </a>
                @endif
            </div>

            <div class="text-muted">
                {{ __('pagination.page_info', [
                    'current' => $currentRankings->currentPage(),
                    'last' => $currentRankings->lastPage(),
                ]) }}
            </div>

            <div>
                @if ($currentRankings->hasMorePages())
                    <a href="{{ $currentRankings->nextPageUrl() }}" class="btn btn-outline-primary">
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
