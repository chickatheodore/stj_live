@extends('layouts/contentLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
    <style rel="stylesheet">
        .custselect {
            top: -24px;
            color: rgba(34, 41, 47, 0.4) !important;
            opacity: 1;
            font-size: 0.7rem;
        }
    </style>
@endsection

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-10 col-md-12 col-12 justify-content-center">

            <div class="card bg-authentication rounded-0 mb-0" style="background-color: #fff">
                <div class="row m-0">
                    <div class="col-lg-6 col-12 p-0">

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Registrasi Member</h4>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <div class="form-label-group">
                                        <input id="name" type="text" class="form-control" name="name" placeholder="Nama Sesuai KTP" value="{{ $member->name }}" readonly autofocus>
                                        <label for="name">Username</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="text" id="nik" name="nik" class="form-control" placeholder="Nomor KTP" value="{{ $member->nik }}" readonly>
                                        <label for="nik">Nomor KTP</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Alamat" value="{{ $member->address }}" readonly>
                                        <label for="address">Alamat</label>
                                    </div>

                                    <div class="form-label-group">
                                        <select class="form-control city_id" id="city_id" name="city_id" readonly="readonly">
                                            @if(!$member->city_id)
                                                <option></option>
                                            @else
                                                <option value="{{ $member->city_id }}">{{ $member->city->name }}</option>
                                            @endif
                                        </select>
                                        <label for="city_id" class="custselect">Kota</label>
                                    </div>
                                    <div class="form-label-group">
                                        <select class="form-control province_id" id="province_id" name="province_id" readonly="readonly">
                                            @if(!$member->province_id)
                                                <option></option>
                                            @else
                                                <option value="{{ $member->province_id }}">{{ $member->province->name }}</option>
                                            @endif
                                        </select>
                                        <label for="province_id" class="custselect">Propinsi</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Kode POS" value="{{ $member->postal_code }}" readonly>
                                        <label for="postal_code">Kode POS</label>
                                    </div>
                                    <div class="form-label-group">
                                        <select class="form-control country_id" id="country_id" name="country_id" readonly="readonly">
                                            @if(!$member->country_id)
                                                <option></option>
                                            @else
                                                <option value="{{ $member->country_id }}">{{ $member->country->name }}</option>
                                            @endif
                                        </select>
                                        <label for="country_id" class="custselect">Negara</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input id="phone" type="text" class="form-control" name="phone" placeholder="Nomor Telepon" value="{{ $member->phone }}" readonly>
                                        <label for="phone">Nomor Telepon</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Penempatan Member</h4>
                                </div>
                            </div>
                            <p class="px-2"></p>
                            <div class="card-content">
                                <div class="card-body pt-0">

                                    <div class="form-label-group">
                                        <select class="form-control sponsor_id" id="sponsor_id" name="sponsor_id" readonly="readonly">
                                            @if($member->sponsor_id)
                                            <option value="{{ $member->sponsor_id }}">{{ $member->sponsor->code }} - {{ $member->sponsor->name }}</option>
                                            @else
                                            <option></option>
                                            @endif
                                        </select>
                                        <label for="sponsor_id" class="custselect">Sponsor</label>
                                    </div>

                                    <div class="form-label-group">
                                        <select class="form-control upline_id" id="upline_id" name="upline_id" readonly="readonly">
                                            @if($member->upline_id)
                                            <option value="{{ $member->upline_id }}">{{ $member->upLine->code }} - {{ $member->upLine->name }}</option>
                                            @else
                                            <option></option>
                                            @endif
                                        </select>
                                        <label for="upline_id" class="custselect">Upline</label>
                                    </div>

                                </div>
                            </div>
                        </div> -->

                    </div>

                    <div class="col-lg-6 col-12 p-0">

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Rincian Bank</h4>
                                </div>
                            </div>
                            <p class="px-2">Wajib Diisi.</p>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <div class="form-label-group">
                                        <input id="bank" type="text" class="form-control" name="bank" placeholder="Bank" value="{{ $member->bank }}" readonly autofocus>
                                        <label for="bank">Bank</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input id="account_number" type="text" class="form-control" name="account_number" placeholder="Nomor Rekening" value="{{ $member->account_number }}" readonly>
                                        <label for="account_number">Nomor Rekening</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input id="account_name" type="text" class="form-control" name="account_name" placeholder="Nama Nasabah" value="{{ $member->account_name }}" readonly>
                                        <label for="account_name">Nama Nasabah</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Member ID</h4>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <div class="form-label-group">
                                        <input id="code" type="text" class="form-control" style="border: solid 1px #ff0000;" name="code" placeholder="Member ID" value="{{ $member->code }}" autofocus readonly>
                                        <label for="code">Member ID</label>
                                    </div>
                                    <div class="form-label-group hidden">
                                        <input id="username" type="text" class="form-control" name="username" placeholder="User Name" value="{{ $member->username }}" autofocus readonly>
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="form-label-group">
                                        <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email" required> -->
                                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ $member->email }}" readonly>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
