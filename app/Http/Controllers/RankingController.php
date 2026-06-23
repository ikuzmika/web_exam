<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\DifficultyLevel;
use App\Models\Result;
use App\Models\SizeCategory;
use App\Models\Track;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function rank(Request $request)
    {
        $selectedYear = $request->input('year');

        if (!$selectedYear) {
            $selectedYear = Competition::selectRaw('YEAR(date) as year')
                ->orderByDesc('year')
                ->value('year');
        }

        $totalTracksQuery = Track::query()
            ->whereHas('competition', function ($q) use ($selectedYear) {
                $q->whereYear('date', $selectedYear);
            });

        $this->applyTrackFiltersToTrackQuery($totalTracksQuery, $request);

        $totalTracks = $totalTracksQuery->count();

        $minimumRuns = ceil($totalTracks * 0.6);

        $latvianRankingQuery = Result::query()
            ->with([
                'pair.dog.handler',
                'pair.dog.sizeCategory',
            ])
            ->whereHas('track.competition', function ($q) use ($selectedYear) {
                $q->whereYear('date', $selectedYear);
            })
            ->whereHas('resultStatus', function ($q) {
                $q->whereIn('name', ['OK', 'DQ']);
            })
            ->select('pair_id')
            ->selectRaw('SUM(points) as total_points')
            ->selectRaw('COUNT(*) as result_count')
            ->groupBy('pair_id')
            ->orderByDesc('total_points');


        $this->applyTrackFiltersToResultQuery($latvianRankingQuery, $request);
        $this->applyDogFiltersToResultQuery($latvianRankingQuery, $request);

        if ($totalTracks > 0) {
            $latvianRankingQuery->havingRaw('COUNT(*) >= ?', [$minimumRuns]);
        }

        $latvianRankings = $latvianRankingQuery
            ->paginate(10, ['*'], 'latvian_page')
            ->withQueryString();


        $bestPairsQuery = Result::query()
            ->with([
                'pair.dog.handler',
                'pair.dog.sizeCategory',
            ])
            ->whereHas('track.competition', function ($q) use ($selectedYear) {
                $q->whereYear('date', $selectedYear);
            })
            ->select('pair_id')
            ->selectRaw('SUM(points) as total_points')
            ->selectRaw('COUNT(*) as result_count')
            ->groupBy('pair_id')
            ->orderByDesc('total_points');

        $this->applyTrackFiltersToResultQuery($bestPairsQuery, $request);
        $this->applyDogFiltersToResultQuery($bestPairsQuery, $request);

        $bestPairs = $bestPairsQuery
            ->paginate(10, ['*'], 'best_page')
            ->withQueryString();

        // dati filtru dropdown izvēlei
        $competitions = Competition::orderByDesc('date')->get();
        $sizeCategories = SizeCategory::orderBy('name')->get();
        $difficultyLevels = DifficultyLevel::orderBy('name')->get();

        $years = Competition::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('rankings.index', compact(
            'latvianRankings',
            'bestPairs',
            'competitions',
            'sizeCategories',
            'difficultyLevels',
            'years',
            'selectedYear',
            'totalTracks',
            'minimumRuns'
        ));
    }

    public function filter(Request $request)
    {
        return $this->rank($request);
    }

    // filtrēšanas metodes
    private function applyTrackFiltersToTrackQuery($query, Request $request)
    {
        if ($request->filled('competition_id')) {
            $query->where('competition_id', $request->competition_id);
        }

        if ($request->filled('difficulty_level_id')) {
            $query->where('difficulty_level_id', $request->difficulty_level_id);
        }
    }

    private function applyTrackFiltersToResultQuery($query, Request $request)
    {
        if ($request->filled('competition_id')) {
            $query->whereHas('track', function ($q) use ($request) {
                $q->where('competition_id', $request->competition_id);
            });
        }

        if ($request->filled('difficulty_level_id')) {
            $query->whereHas('track', function ($q) use ($request) {
                $q->where('difficulty_level_id', $request->difficulty_level_id);
            });
        }
    }

    private function applyDogFiltersToResultQuery($query, Request $request)
    {
        if ($request->filled('size_category_id')) {
            $query->whereHas('pair.dog', function ($q) use ($request) {
                $q->where('size_category_id', $request->size_category_id);
            });
        }
    }
}
