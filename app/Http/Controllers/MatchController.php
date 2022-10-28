<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateMatchResult;
use App\Jobs\UpdateMatches;
use App\Models\Match;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $matches = Match::query()
                        ->where('starts_at', '>=', now()->utc()->startOfDay())
                        ->where('status', 'pending')
                        ->when($request->category, function ($query) use ($request) {
                            $query->where('category', $request->category);
                        })
                        ->when($request->competition, function ($query) use ($request) {
                            $query->where('competition', $request->competition);
                        })
                        ->whereHas('odds', function ($query) use ($request) {
                            if ($request->has('odds')) {
                                $query->whereRaw(\DB::raw(sprintf(
                                    "((name = matches.home_team and val >= %s) or (name = '%s' and val >= %s) or (name =  matches.away_team and val >= %s))",
                                    $request->odds['home'],
                                    'Draw',
                                    $request->odds['draw'],
                                    $request->odds['away']
                                )));
                            }
                        }, '>=', 3)
                        ->orderBy('starts_at')
                        ->with('odds')
                        ->paginate(50);
        $categories = Match::query()->distinct()->pluck('category')->sort();
        $competitions = Match::query()->when($request->category, function ($query) use ($request) {
            $query->where('category', $request->category);
        })->distinct()->pluck('competition')->sort();
        return view('match.index', compact('matches', 'categories', 'competitions'));
    }

    public function ended(Request $request)
    {
        $matches = Match::query()
        ->where('status', 'finished')
        ->when($request->category, function ($query) use ($request) {
            $query->where('category', $request->category);
        })
        ->when($request->competition, function ($query) use ($request) {
            $query->where('competition', $request->competition);
        })
        ->when($request->match_date, function ($query) use ($request) {
            $date = Carbon::parse($request->match_date)->utc();
            $query->whereBetween('starts_at', [$date->clone()->startOfDay(),$date->endOfDay()]);
        })
        ->whereHas('odds', function ($query) use ($request) {
            if ($request->has('odds')) {
                $query->whereRaw(\DB::raw(sprintf(
                    "((name = matches.home_team and val >= %s) or (name = '%s' and val >= %s) or (name =  matches.away_team and val >= %s))",
                    $request->odds['home'],
                    'Draw',
                    $request->odds['draw'],
                    $request->odds['away']
                )));
            }
        }, '>=', 3)
                        ->orderBy('starts_at', 'DESC')
                        ->with('odds')
                        ->paginate(50);
        $categories = Match::query()->distinct()->pluck('category')->sort();
        $competitions = Match::query()->when($request->category, function ($query) use ($request) {
            $query->where('category', $request->category);
        })->distinct()->pluck('competition')->sort();
        return view('match.ended', compact('matches', 'categories', 'competitions'));
    }
}
