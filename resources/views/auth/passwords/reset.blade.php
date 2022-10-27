@extends('layouts.single')

@section('content')
    <div class="container">
        <div class="container-tight py-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" height="36" alt="">
            </div>
            <form class="card card-md" action="{{ route('password.update') }}" method="post">
                @csrf
                <div class="card-body">
                    <h2 class="mb-5 text-center">{{ __('Reset Password') }}</h2>
                    @if($errors->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <div class="row row-0">
                                        <div
                                            class="col-12 p-2">  {!!  str_replace("\n","<hr style='margin: 4px 0px'>", array_values($errors->toArray())[0][0]) !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <input type="hidden" name="guard" value="{{ request('guard') }}">
                    <input type="hidden" name="token" value="{{ request('token') }}">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="text" value="{{ old('email',request()->email) }}" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Enter email" autocomplete="off">
                        @error('email')
                        <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                     </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Password') }}</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Enter Password" autocomplete="off">
                        @error('password')
                        <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                     </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Confirm Password') }}</label>
                        <input name="password_confirmation" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Confirm Password" autocomplete="off">
                        @error('password')
                        <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                     </span>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted">
                <a href="{{ url('/login') }}" tabindex="-1">Sign in</a>
            </div>
        </div>
    </div>
@endsection
