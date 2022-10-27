<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateMatches;
use App\Models\Match;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        // dd((new UpdateMatches("betika"))->handle());
        $programs = [];
        $matches = Match::query()
                        ->where('starts_at','>=', now())
                        ->whereHas('odds',function($query) use($request){
                            if($request->has('odds')){
                                $query->whereRaw(\DB::raw(sprintf("((name = matches.home_team and val >= %s) or (name = '%s' and val >= %s) or (name =  matches.away_team and val >= %s))",
                                 $request->odds['home'],  
                                 'Draw',
                                 $request->odds['draw'], 
                                 $request->odds['away'])));
                            }
                        },'>=',3)
                        ->with('odds')
                        ->paginate(50);
        return view('match.index', compact('programs','matches'));
    }
}
