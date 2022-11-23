<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateMatchResult;
use App\Jobs\UpdateMatches;
use App\Models\Game;
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
        $matches = Game::query()
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
                        ->when($request->odds, function ($query) use ($request) {
                            $query->whereRaw(\DB::raw(sprintf(
                                "odds_home %s %s and odds_draw %s %s and odds_away %s %s",
                                $request->odds['home'] >= 0 ? '>=' : '<=',
                                abs($request->odds['home'] ?? 0),
                                $request->odds['draw'] >= 0 ? '>=' : '<=',
                                abs($request->odds['draw'] ?? 0),
                                $request->odds['away'] >= 0 ? '>=' : '<=',
                                abs($request->odds['away'] ?? 0)
                            )));
                        })
                        ->orderBy('starts_at')
                        ->paginate(50);
        $categories = Game::query()->distinct()->pluck('category')->sort();
        $competitions = Game::query()->when($request->category, function ($query) use ($request) {
            $query->where('category', $request->category);
        })->distinct()->pluck('competition')->sort();
        return view('match.index', compact('matches', 'categories', 'competitions'));
    }

    public function ended(Request $request)
    {
        $matches = Game::query()
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
         ->when($request->odds, function ($query) use ($request) {
             $query->whereRaw(\DB::raw(sprintf(
                 "odds_home %s %s and odds_draw %s %s and odds_away %s %s",
                 $request->odds['home'] >= 0 ? '>=' : '<=',
                 abs($request->odds['home'] ?? 0),
                 $request->odds['draw'] >= 0 ? '>=' : '<=',
                 abs($request->odds['draw'] ?? 0),
                 $request->odds['away'] >= 0 ? '>=' : '<=',
                 abs($request->odds['away'] ?? 0)
             )));
         })
        ->orderBy('starts_at', 'DESC')
        ->paginate(15);

        $categories = Game::query()->distinct()->pluck('category')->sort();
        $competitions = Game::query()->when($request->category, function ($query) use ($request) {
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
            $arbitrage = ArbitrageRun::query()->with('matches', 'matches.match', 'matches.run')->findOrFail($request->run);
            return view('match.dryrun', compact('arbitrage'));
        }
    }
}
