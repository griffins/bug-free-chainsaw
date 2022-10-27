@extends('layouts.app')
@section('title')
    {{ ucfirst(request('market','all')) }} / Matches
@stop
@section('page-pretitle')
    Card database
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-6 col-md-6">
                    <label class="form-label">Odds Over</label>
                    <div class="input-group">
                        <span class="input-group-text"> 1 </span>
                        <input type="number" name="odds[home]" onchange="updateFilters(this)" class="form-control" placeholder="Home Team Odds" value="{{ request('odds')['home'] ?? 0 }}">
                        <span class="input-group-text">X</span>
                        <input type="number" class="form-control" name="odds[draw]" onchange="updateFilters(this)" placeholder="Draw Odds" value="{{ request('odds')['draw'] ?? 0 }}">
                        <span class="input-group-text">2</span>
                        <input type="number" class="form-control" name="odds[away]" onchange="updateFilters(this)" placeholder="Away Team Odds" value="{{ request('odds')['away'] ?? 0}}">
                    </div>
                </div>
            </div>
        </div>
        <table class="table card-table">
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
                       3 Way Odds
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
                        <td><span class="badge bg-success">{{odd_format($match->home_team_odds,2)}} </span> - <span class="badge bg-primary">{{odd_format($match->draw_odds,2)}}</span> - <span class="badge bg-danger">{{odd_format($match->away_team_odds,2)}}</span></td>
                    </tr>   
                @endforeach
            </tbody>
        </table>
        {{ $matches->appends(request()->except('page'))->render() }}
    </div>
@stop

@section('js_after')
    <script>
        function updateFilters(e) {
            const url = new URL("{{ route('match') }}");
            const inputs = $('input[type=number]');
            for(let selector of inputs){
                const input = $(selector);
                url.searchParams.set(input.prop('name'), input.val())
            }
            window.location.href = url.toString()
        }
    </script>
@append