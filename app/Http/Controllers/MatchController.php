<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateMatchResult;
use App\Jobs\UpdateMatches;
use App\Models\Match;
use App\Models\ArbitrageMatch;
use App\Models\ArbitrageRun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        if (count($request->all()) === 0) {
            return redirect(route('match', ['state' =>'pending','match_date' => now()->toDateString()]));
        }
        $matches = Match::query()
                        ->when($request->match_date, function ($query) use ($request) {
                            $date = Carbon::parse($request->match_date)->utc();
                            $query->whereBetween('starts_at', [$date->clone()->startOfDay(),$date->endOfDay()]);
                        })
                        ->when($request->category, function ($query) use ($request) {
                            $query->where('category', $request->category);
                        })
                        ->when($request->state, function ($query) use ($request) {
                            $query->where('status', $request->state);
                        })
                        ->when($request->competition, function ($query) use ($request) {
                            $query->where('competition', $request->competition);
                        })
                        ->whereHas('odds', function ($query) use ($request) {
                            if ($request->has('odds')) {
                                $query->whereRaw(\DB::raw(sprintf(
                                    "((name = matches.home_team and val %s %s) or (name = 'Draw' and val %s %s) or (name =  matches.away_team and val %s %s))",
                                    $request->odds['home'] >= 0 ? '>=' : '<=',
                                    abs($request->odds['home'] ?? 0),
                                    $request->odds['draw'] >= 0 ? '>=' : '<=',
                                    $request->odds['draw'] ?? 0,
                                    $request->odds['away'] >= 0 ? '>=' : '<=',
                                    abs($request->odds['away'] ?? 0)
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
                    "((name = matches.home_team and val %s %s) or (name = 'Draw' and val %s %s) or (name =  matches.away_team and val %s %s))",
                    $request->odds['home'] >= 0 ? '>=' : '<=',
                    abs($request->odds['home'] ?? 0),
                    $request->odds['draw'] >= 0 ? '>=' : '<=',
                    $request->odds['draw'] ?? 0,
                    $request->odds['away'] >= 0 ? '>=' : '<=',
                    abs($request->odds['away'] ?? 0)
                )));
            }
        }, '>=', 3)
                        ->orderBy('starts_at', 'DESC')
                        ->with('odds')
                        ->paginate(15);
        $categories = Match::query()->distinct()->pluck('category')->sort();
        $competitions = Match::query()->when($request->category, function ($query) use ($request) {
            $query->where('category', $request->category);
        })->distinct()->pluck('competition')->sort();
        return view('match.ended', compact('matches', 'categories', 'competitions'));
    }

    public function dryrun(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->match) {
                $arbitrage = \DB::transaction(function () use ($request) {
                    $arbitrage = ArbitrageRun::query()->create([
                'user_id' => auth()->user()->id,
                'home' => $request->has('home'),
                'draw' => $request->has('draw'),
                'away' => $request->has('away')
            ]);
                    $matches = array_keys($request->match);
                    foreach ($matches as $match) {
                        $arbitrage->matches()->save(new ArbitrageMatch(['match_id' =>  $match]));
                    }
                    return $arbitrage;
                });
                return redirect(route('match.dryrun', ['run' => $arbitrage]));
            } else {
                return back()->withError("No matches selected!");
            }
        } else {
            $arbitrage = ArbitrageRun::query()->with('matches', 'matches.match', 'matches.run', 'matches.match.odds')->findOrFail($request->run);
            return view('match.dryrun', compact('arbitrage'));
        }
    }
}
