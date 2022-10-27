@extends('layouts.app')
@section('title')
    Create User
@stop
@section('page-header-actions')
    <div class="d-flex">
        <a href="{{ route('user.index')  }}" class="btn btn-primary">
            @icon('arrow-back-up')
            Back
        </a>
    </div>
@stop
@section('content')
    <form method="post" action="{{ route('user.store') }}" autocomplete="off" class="form-horizontal">
        @csrf
        @method('post')
        <div class="card">
            <div class="card-header">
                Add User
            </div>
            <div class="card-body">
                <label class="form-label">{{ __('Name') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name" id="input-name" type="text"
                               placeholder="{{ __('Name') }}" value="{{ old('name') }}"
                               required="true" aria-required="true"/>
                        @if ($errors->has('name'))
                            <span id="name-error" class="error text-danger"
                                  for="input-name">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <label class="mt-3 form-label">{{ __('Email') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email" id="input-email" type="email"
                               placeholder="{{ __('Email') }}" value="{{ old('email') }}" required/>
                        @if ($errors->has('email'))
                            <span id="email-error" class="error text-danger"
                                  for="input-email">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>

                <label class="mt-3 form-label"
                       for="input-password">{{ __(' Password') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               input type="password" name="password" id="input-password"
                               placeholder="{{ __('Password') }}" value="" required/>
                        @if ($errors->has('password'))
                            <span id="name-error" class="error text-danger"
                                  for="input-name">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>

                <label class="mt-3 form-label"
                       for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input class="form-control" name="password_confirmation"
                               id="input-password-confirmation" type="password"
                               placeholder="{{ __('Confirm Password') }}" value="" required/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </div>
    </form>
@endsection