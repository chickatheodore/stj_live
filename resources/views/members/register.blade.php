@extends('layouts/contentLayoutMaster')

@section('title', 'Register Page')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" method="POST" action="{{ route('member.registration') }}">
                    @csrf

                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Registrasi Member</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Isi form di bawah ini.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">
                                            <div class="form-group">
                                                <label for="name">Username <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Sesuai KTP" value="{{ old('name') }}" required autofocus>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="nik">Nomor KTP</label>
                                                <input type="text" id="nik" name="nik" class="form-control" placeholder="Nomor KTP">
                                            </div>

                                            <div class="form-group">
                                                <label for="address">Alamat</label>
                                                <input type="text" id="address" name="address" class="form-control" placeholder="Alamat">
                                            </div>

                                            <div class="form-group">
                                                <label for="city_id">Kota</label>
                                                <select class="form-control city_id" id="city_id" name="city_id">
                                                    <option value=""></option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="province_id">Propinsi</label>
                                                <select class="form-control province_id" id="province_id" name="province_id">
                                                    <option value=""></option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="postal_code">Kode POS</label>
                                                <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Kode POS">
                                            </div>
                                            <div class="form-group">
                                                <label for="country_id">Negara</label>
                                                <select class="form-control country_id" id="country_id" name="country_id">
                                                    <option value=""></option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon<span class="small d-lg-block text-danger">*) Wajib diisi (1 nomor saja)</span></label>
                                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Rincian Bank</h4>
                                            </div>
                                        </div>
                                        <p class="px-2"><span class="small d-lg-block text-danger">*) Wajib diisi semua</span></p>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <div class="form-group">
                                                    <label for="bank">Bank</label>
                                                    <input id="bank" type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" placeholder="Bank" value="{{ old('bank') }}" required autocomplete="bank" autofocus>
                                                    @error('bank')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="account_number">Nomor Rekening</label>
                                                    <input id="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" placeholder="Nomor Rekening" value="{{ old('account_number') }}" required>
                                                    @error('account_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="account_name">Nama Nasabah</label>
                                                    <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" placeholder="Nama Nasabah" value="{{ old('account_name') }}" required>
                                                    @error('account_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Member ID</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <div class="form-group">
                                                    <label for="code">Member ID</label>
                                                    <input id="code" type="text" class="form-control" name="code" placeholder="Member ID" value="{{ old('code') }}" autofocus readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input id="username" type="text" class="form-control" name="username" placeholder="User Name" value="{{ old('username') }}" autofocus readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password-confirm">Confirm Password</label>
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary float-right btn-inline mb-50">Register</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/members/register.js')) }}"></script>
@endsection
