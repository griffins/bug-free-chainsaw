@extends('layouts.single')

@section('content')
    <div class="container-tight py-6">
        <div class="row">
            <div class="col m-auto" style="max-width:400px">
                <div class="text-center my-4">
                    <img src="{{ asset('logo.svg') }}" height="64" alt="">
                    <h4 class="my-3">{{ config('app.name') }}</h4>
                </div>
                <form class="card card-md" action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <h2 class="">{{ __('Reset Password') }}</h2>
                        @if(isset($message) || session()->has('message'))
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-danger" role="alert">
                                        <div class="row row-0">
                                            <div
                                                    class="col-12 p-2">  {!! __( str_replace("\n","<hr style='margin: 4px 0px'>", $message ?? session('message'))) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted">
                    <a href="{{ url('/login') }}" tabindex="-1">Sign in</a>
                </div>
            </div>
        </div>
    </div>
@endsection
