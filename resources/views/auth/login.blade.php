@extends('layouts.single')

@section('content')
    <div class="container-tight py-6">
        <div class="row">
            <div class="col m-auto" style="max-width:400px">
                <div class="text-center my-4">
                    <img src="{{ asset('logo.svg') }}" height="64" alt="">
                    <h4 class="my-3">{{ config('app.name') }}</h4>
                </div>
                <form class="card card-md" action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <h2 class="">Login to your account</h2>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" value="{{ old('email') }}" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter email" autocomplete="off">
                            @error('email')
                            <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                     </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter password" autocomplete="off">
                            @error('password')
                            <span class="invalid-feedback">
                      <strong>{{ $message }}</strong>
                     </span>
                            @enderror
                        </div>
                        <div class="">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="form-check-label">Remember me on this device</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted my-3">
                    Forgot your password? <a href="{{ route('password.request') }}" tabindex="-1">Reset</a>
                </div>
            </div>
        </div>
    </div>
@endsection
