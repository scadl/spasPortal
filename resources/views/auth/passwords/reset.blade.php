@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-key"></i>
                    {{ __('ui.resetpw') }}
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="@if($express) {{route('nepwupd',$uid)}} @else {{ route('password.update') }} @endif">

                        @csrf
                        <input type="hidden" name="token" value="{{ $token ?? '' }}">
                        <input type="hidden" name="origin" value="{{ $origin ?? '' }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus @if($express) readonly @endif>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('ui.new_pred') }} {{ __('ui.pwd_lb') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('ui.pwd_lb2') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-secondary" href="/{{ $origin ?? '' }}">
                                    <i class="fas fa-chevron-left"></i>
                                    {{__('ui.back_catlog')}}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    {{ __('ui.resetpw') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
