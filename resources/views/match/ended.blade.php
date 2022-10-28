@extends('layouts.app')
@section('title')
    Finished/Previous Matches
@stop
@section('page-pretitle')
    Football
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <label class="form-label">Filters</label>
                <div class="col-lg-4 col-md-4">
                    <div class="form-floating">
                        <select class="form-select form-filter" name="category" onchange="updateFilters()">
                            <option value="">Select Category</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $category }}" @if(request('category') === $category) selected @endif>{{ $category }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Category</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-floating">
                        <select class="form-select form-filter" name="competition" onchange="updateFilters()">
                            <option value="">Select Competition</option>
                            @foreach($competitions as $key => $competition)
                                <option value="{{ $competition }}" @if(request('competition') === $competition) selected @endif>{{ $competition }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Competition</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mt-2">
                    <label class="form-label">Odds Over</label>
                    <div class="input-group">
                        <span class="input-group-text"> 1 </span>
                        <input type="number" name="odds[home]" onchange="updateFilters()" class="form-control form-filter" placeholder="Home Team Odds" value="{{ request('odds')['home'] ?? 0 }}">
                        <span class="input-group-text">X</span>
                        <input type="number" class="form-control form-filter" name="odds[draw]" onchange="updateFilters()" placeholder="Draw Odds" value="{{ request('odds')['draw'] ?? 0 }}">
                        <span class="input-group-text">2</span>
                        <input type="number" class="form-control form-filter" name="odds[away]" onchange="updateFilters()" placeholder="Away Team Odds" value="{{ request('odds')['away'] ?? 0}}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mt-2">
                    <label class="form-label">Date</label>
                    <div class="input-icon mb-2">
                      <input class="form-control form-filter" name="match_date" onchange="updateFilters()" placeholder="Select a date" id="datepicker" value="{{  request('match_date', now()->utc()->startOfDay()->toDateString()) }}">
                      <span class="input-icon-addon">
                        @icon('calendar')
                      </span>
                    </div>
                </div>
            </div>
        </div>
        <table class="table card-table mb-2">
            <thead>
                <tr>
                    <th>
                        Category
                    </th>
                    <th>
                        Competition
                    </td>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($matches as $match)
                    <tr>
                        <td>{{$match->category}}</td>
                        <td>{{$match->competition}}</td>
                        <td>{{$match->home_team}}</td>
                        <td>{{$match->away_team}}</td>
                        <td>{{$match->starts_at->diffForHumans()}}</td>
                        <td><span class="badge bg-success">{{odd_format($match->home_team_odds,2)}} </span> - <span class="badge bg-primary">{{odd_format($match->draw_odds,2)}}</span> - <span class="badge bg-danger">{{odd_format($match->away_team_odds,2)}}</span></td>
                        <td>{{$match->home_team_score}} - {{ $match->away_team_score }} [{{$match->result}}]</td>
                    </tr>   
                @endforeach
            </tbody>
        </table>
        
        <div class="@if($matches->hasPages()) mt-2 @endif">
            {{ $matches->appends(request()->except('page'))->render() }}
            </div>
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