@extends('layouts.app')
@section('title')
    Pending Matches Today
@stop
@section('page-pretitle')
    Football
@stop
@section('content')
    <div class="card">
        <form method="POST" action="{{ route('match.dryrun') }}">
            @csrf
            <div class="card-body">
                <div class="row mb-3">
                        <div class="col-lg-4 col-md-6 mt-2">
                            <div class="form-floating">
                                <select class="form-select form-filter" name="state" onchange="updateFilters(this)">
                                    <option value="">Select</option>
                                    <option value="pending" @if(request('state') === 'pending') selected @endif>Pending</option>
                                    <option value="finished" @if(request('state') === 'finished') selected @endif>Finished</option>
                                </select>
                                <label for="floatingSelect">Match State</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-2">
                            <div class="form-floating">
                                <select class="form-select form-filter" name="category" onchange="updateFilters(this)">
                                    <option value="">Select</option>
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $category }}" @if(request('category') === $category) selected @endif>{{ $category }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Category</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-2">
                            <div class="form-floating">
                                <select class="form-select form-filter" name="competition" onchange="updateFilters(this)">
                                    <option value="">Select Competition</option>
                                    @foreach($competitions as $key => $competition)
                                        <option value="{{ $competition }}" @if(request('competition') === $competition) selected @endif>{{ $competition }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Competition</label>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 mt-2">
                            <label class="form-label">Odds Over</label>
                            <div class="input-group">
                                <span class="input-group-text"> 1 </span>
                                <input type="number" name="odds[home]" onchange="updateFilters(this)" class="form-control form-filter" placeholder="Home Team Odds" value="{{ request('odds')['home'] ?? 0 }}">
                                <span class="input-group-text">X</span>
                                <input type="number" class="form-control form-filter" name="odds[draw]" onchange="updateFilters(this)" placeholder="Draw Odds" value="{{ request('odds')['draw'] ?? 0 }}">
                                <span class="input-group-text">2</span>
                                <input type="number" class="form-control form-filter" name="odds[away]" onchange="updateFilters(this)" placeholder="Away Team Odds" value="{{ request('odds')['away'] ?? 0}}">
                            </div>
                        </div>
                    <div class="col-lg-6 col-md-6 mt-2">
                        <div class="form-label">Your arbitrage choices</div>
                        <div class="d-flex flex-colums">
                            <div class="mt-2">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" name="home" type="checkbox">
                                    <span class="form-check-label">Home</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" name="draw" type="checkbox">
                                    <span class="form-check-label">Draw</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" name="away" type="checkbox">
                                    <span class="form-check-label">Away</span>
                                </label>
                        </div>
                        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table card-table table-responsive table-stripped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <input type="checkbox" onchange="toggleChecks(this)" class="form-check-input">
                        </th>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $x => $match)
                        <tr>
                            <td>{{$x+1}}</td>
                            <td><input type="checkbox" name="match[{{ $match->id }}]" class="form-check-input match-select"></td>
                            <td>{{$match->category}}</td>
                            <td>{{$match->competition}}</td>
                            <td>{{$match->home_team}}</td>
                            <td>{{$match->away_team}}</td>
                            <td>{{ $match->starts_at->diffForHumans()}}</td>
                            <td><span class="badge bg-success">{{odd_format($match->home_team_odds,2)}} </span> - <span class="badge bg-primary">{{odd_format($match->draw_odds,2)}}</span> - <span class="badge bg-danger">{{odd_format($match->away_team_odds,2)}}</span></td>
                        </tr>   
                    @endforeach
                </tbody>
            </table>
            <div class="@if($matches->hasPages()) mt-2 @endif">
            {{ $matches->appends(request()->except('page'))->render() }}
            </div>
        </form>
    </div>
@stop

@section('js_after')
    <script>
        function toggleChecks(e){
            $('.match-select').prop('checked', e.checked)
        }
        function updateFilters(e) {
            const url = new URL("{{ route('match') }}");
            const inputs = $('.form-filter');
            for(let selector of inputs){
                const input = $(selector);
                url.searchParams.set(input.prop('name'), input.val())
            }
            window.location.href = url.toString()
        }
    </script>
@append