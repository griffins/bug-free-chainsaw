@extends('layouts.app')
@section('title')
    Arbitrage Dry Run ({{ $arbitrage->formula}})
@stop
@section('page-pretitle')
    Football
@stop
@section('content')
    <div class="card">
        <table class="table card-table mb-2">
            <thead>
                <tr>
                    <th>
                        Home Team
                    </th>
                    <th>
                        Away Team
                    </th>
                    <th>
                        Match Time
                    </th>
                    <th>
                       3 Way Odds
                    </th>
                    <th>
                        Result
                    </th>
                    <th>
                        Winnings
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($arbitrage->matches as $run)
                    <tr>
                        <td>{{$run->match->home_team}}</td>
                        <td>{{$run->match->away_team}}</td>
                        <td>{{$run->match->starts_at->diffForHumans()}}</td>
                        <td><span class="badge bg-success">{{odd_format($run->match->home_team_odds,2)}} </span> - <span class="badge bg-primary">{{odd_format($run->match->draw_odds,2)}}</span> - <span class="badge bg-danger">{{odd_format($run->match->away_team_odds,2)}}</span></td>
                        <td>{{$run->match->home_team_score}} - {{ $run->match->away_team_score }} {{$run->match->result}}</td>
                        <td>{{$run->winnings($arbitrage) ?? '-' }}</td>
                    </tr>   
                @endforeach
                <tr>
                    <td colspan="5">Total possible winnings</td>
                    <td>{{$arbitrage->winnings}}</td>
                </tr>  
            </tbody>
        </table>
    </div>        
@stop

@section('js_after')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    	window.Litepicker && (new Litepicker({
    		element: document.getElementById('datepicker'),
            autoRefresh: true,
    		buttonText: {
    			previousMonth: `@icon('chevron-left')`,
    			nextMonth: `@icon('chevron-right')`,
    		},
            setup: (picker) => {
                picker.on('selected', (date1) => {
                    updateFilters()
                });
            },
    	}));
    });
         function updateFilters() {
            const url = new URL("{{ route('match.ended') }}");
            const inputs = $('.form-filter');
            for(let selector of inputs){
                const input = $(selector);
                url.searchParams.set(input.prop('name'), input.val())
            }
            window.location.href = url.toString()
        }
    </script>
@append