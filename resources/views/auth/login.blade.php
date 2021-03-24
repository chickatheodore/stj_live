@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection

@section('content')
<section class="row flexbox-container">
  <div class="col-xl-8 col-11 d-flex justify-content-center">
    <div class="card bg-authentication rounded-0 mb-0">
      <div class="row m-0">
        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
          <img src="{{ asset('images/pages/login.png') }}" alt="branding logo">
        </div>
        <div class="col-lg-6 col-12 p-0">
          <div class="card rounded-0 mb-0 px-2">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="mb-0">Login</h4>
              </div>
            </div>
            <p class="px-2">Welcome back, please login to your account.</p>
            <div class="card-content">
              <div class="card-body pt-1">
                @isset($url)
                <form method="POST" action='{{ url("$url/login") }}'>
                @else
                <form method="POST" action="{{ route('login') }}">
                @endisset
                  @csrf
                  <fieldset class="form-label-group form-group position-relative has-icon-left">

                    <input id="username" type="number" class="form-control @error('username') is-invalid @enderror"
                      name="username" placeholder="Member ID" value="{{ old('username') }}" required autocomplete="username"
                      autofocus>

                    <div class="form-control-position">
                      <i class="feather icon-user"></i>
                    </div>
                    <label for="username">Member ID</label>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </fieldset>

                  <fieldset class="form-label-group position-relative has-icon-left">

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                      name="password" placeholder="Password" required autocomplete="current-password">

                    <div class="form-control-position">
                      <i class="feather icon-lock"></i>
                    </div>
                    <label for="password">Password</label>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </fieldset>
                  <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="text-left">
                      <fieldset class="checkbox">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                          <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                          <span class="vs-checkbox">
                            <span class="vs-checkbox--check">
                              <i class="vs-icon feather icon-check"></i>
                            </span>
                          </span>
                          <span class="">Remember me</span>
                        </div>
                      </fieldset>
                    </div>
                    @if (Route::has('password.request'))
                    <div class="text-right"><a class="card-link" href="{{ route('password.request') }}">
                        Forgot Password?
                      </a></div>
                    @endif

                  </div>
                  <a href="register" class="btn btn-outline-primary float-left btn-inline">Register</a>
                  <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                </form>
              </div>
            </div>

            <div class="login-footer">
              <div class="divider">
                &nbsp;
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
