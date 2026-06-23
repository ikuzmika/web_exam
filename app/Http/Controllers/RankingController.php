<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\DifficultyLevel;
use App\Models\Result;
use App\Models\SizeCategory;
use Illuminate\Http\Request;

class RankingController extends Controller
{

    public function rank(Request $request)
    {
        $query = Result::query()
            ->with([
                'pair.dog.handler',
                'pair.dog.sizeCategory',
                'track.competition',
                'track.difficultyLevel',
            ])
            ->select('pair_id')
            ->selectRaw('SUM(points) as total_points')
            ->selectRaw('COUNT(*) as result_count')
            ->groupBy('pair_id')
            ->orderByDesc('total_points');

        // Filtrs pēc gada
        if ($request->filled('year')) {
            $query->whereHas('track.competition', function ($q) use ($request) {
                $q->whereYear('date', $request->year);
            });
        }

        // Filtrs pēc sacensībām
        if ($request->filled('competition_id')) {
            $query->whereHas('track', function ($q) use ($request) {
                $q->where('competition_id', $request->competition_id);
            });
        }

        // Filtrs pēc suņa izmēra kategorijas
        if ($request->filled('size_category_id')) {
            $query->whereHas('pair.dog', function ($q) use ($request) {
                $q->where('size_category_id', $request->size_category_id);
            });
        }

        // Filtrs pēc trases grūtības līmeņa
        if ($request->filled('difficulty_level_id')) {
            $query->whereHas('track', function ($q) use ($request) {
                $q->where('difficulty_level_id', $request->difficulty_level_id);
            });
        }

        $rankings = $query->paginate(10)->withQueryString();

        $competitions = Competition::orderByDesc('date')->get();
        $sizeCategories = SizeCategory::orderBy('name')->get();
        $difficultyLevels = DifficultyLevel::orderBy('name')->get();

        $years = Competition::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('rankings.index', compact(
            'rankings',
            'competitions',
            'sizeCategories',
            'difficultyLevels',
            'years'
        ));
    }

    /**
     * Atsevišķa metode filtrēšanai.
     * Faktiski tā izmanto to pašu rank() loģiku.
     */
    public function filter(Request $request)
    {
        return $this->rank($request);
    }
}
