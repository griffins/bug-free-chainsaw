@extends('layouts.app')
@section('title')
    Edit Profile
@stop
@section('content')
    <form method="post" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
        @csrf
        @method('put')
        <div class="card">
            <div class="card-header">
                User information
            </div>
            <div class="card-body">
                <label class="form-label">{{ __('Name') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"
                               value="{{ old('name', auth()->user()->name) }}" required="true"
                               aria-required="true"/>
                        @if ($errors->has('name'))
                            <span id="name-error" class="error text-danger"
                                  for="input-name">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <label class="form-label mt-3">{{ __('Email') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email" id="input-email" type="email" placeholder="{{ __('Email') }}"
                               value="{{ old('email', auth()->user()->email) }}" required/>
                        @if ($errors->has('email'))
                            <span id="email-error" class="error text-danger"
                                  for="input-email">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <button type="submit" class="btn btn-outline-info">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
    <div class="card mt-3">
        <form method="post" action="{{ route('profile.password') }}" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card-header">
                Change password
            </div>
            <div class="card-body">
                <label class="form-label" for="input-current-password">{{ __('Current Password') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                               input type="password" name="old_password" id="input-current-password"
                               placeholder="{{ __('Current Password') }}" value="" required/>
                        @if ($errors->has('old_password'))
                            <span id="name-error" class="error text-danger"
                                  for="input-name">{{ $errors->first('old_password') }}</span>
                        @endif
                    </div>
                </div>
                <label class="form-label mt-3" for="input-password">{{ __('New Password') }}</label>
                <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" id="input-password" type="password"
                               placeholder="{{ __('New Password') }}" value="" required/>
                        @if ($errors->has('password'))
                            <span id="password-error" class="error text-danger"
                                  for="input-password">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <label class="form-label mt-3"
                       for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input class="form-control" name="password_confirmation"
                               id="input-password-confirmation" type="password"
                               placeholder="{{ __('Confirm New Password') }}" value="" required/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-info">{{ __('Change password') }}</button>
            </div>
        </form>
    </div>
@endsection