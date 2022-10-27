@extends('layouts.app')
@section('title')
    Buy Player Card
@stop
@section('page-pretitle')
    {{ $card->getNameSpaceTitle() }}
@stop
@section('content')
    <form method="post" action="{{ $card->get_buy_auction_route($auction) }}">
        @csrf
        <div class="card">
            <div class="card-header">
                                  <span class="{{ $card->getNameSpaceForeground()}}">
                            {!! paste_icon(Str::lower($card->getNameSpaceIcon()));  !!} &nbsp;
                        </span>
                <h3 class="card-title">{{ $card->first_name }} {{ $card->last_name }}</h3>
            </div>
            <div class="card-body row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <img src="{{ $card->image_url }}" class="w-100 object-cover">
                </div>
                <div class="col-lg-9 col-md-8 col-sm-6 mt-3">
                    <h2 class="card-title">{{ __('Select Persona to complete purchase') }}</h2>
                    <h4 class="text-muted">Buyout Price: {{ currency($auction->buyout_price) }}</h4>
                    <div class="row row-deck">
                        @foreach($workingPersonas as $name => $persona)
                            <div class="col-md-6 col-lg-4 col-sm-12 p-2">
                                <label class="form-selectgroup-item flex-fill">
                                    <input type="radio" name="persona_id"
                                           id="persona_id-{{ $persona->name }}-radio"
                                           value="{{ $persona->persona_id }}" class="form-selectgroup-input">
                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                        <div class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </div>
                                        <div>
                                            <div class="row">
                                                <div class="col-auto">
                                    <span class="avatar avatar-md"
                                          style="background-image: url(https://www.gravatar.com/avatar/{{ md5($persona->account->email) }}?d=retro)">
                                    </span>
                                                </div>
                                                <div class="col text-truncate text-start">
                                                    <span class="text-reset d-block">{{ $persona->name }}</span>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        {{ $persona->account->email }}
                                                    </div>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        {{ currency($persona->balance) }} Coins
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary">{{ __('Buy Now') }}</button>
            </div>
        </div>
    </form>
@endsection