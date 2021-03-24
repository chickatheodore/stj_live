@extends('layouts/contentLayoutMaster')

@section('title', 'Edit User Page')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">

@endsection

@section('content')
    <!-- users edit start -->
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account"
                               aria-controls="account" role="tab" aria-selected="true">
                                <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Account</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- users edit media object start -->
                            <div class="media mb-2">
                                <a class="mr-2 my-25" href="#">
                                    <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" alt="users avatar"
                                         class="users-avatar-shadow rounded" height="64" width="64">
                                </a>
                                <div class="media-body mt-50">
                                    <h4 class="media-heading">{{ $member->code }}</h4>
                                    <div class="col-12 d-flex mt-1 px-0">
                                        {{ $member->username }}
                                    </div>
                                </div>
                            </div>
                            <!-- users edit media object ends -->
                            <!-- users edit account form start -->
                            @php
                            $edit = isset($member->id);
                            @endphp
                            <form method="post" action="{{ route('member.save') }}">
                                @csrf
                                @if ($edit)
                                    <input type="hidden" name="id" id="id" value="{{ $member->id }}" />
                                @endif
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="code">Kode (kosong utk otomatis)</label>
                                                <input type="text" class="form-control" id="code" name="code" placeholder="Kode" value="{{ $member->code }}"
                                                       data-validation-required-message="This code field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="username">Username (kosong utk otomatis)</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{ $member->username }}"
                                                       data-validation-required-message="This name field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $member->name }}" required
                                                       data-validation-required-message="This name field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $member->email }}"
                                                       required data-validation-required-message="This email field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>NIK</label>
                                                <input type="text" class="form-control" name="nik" placeholder="NIK" value="{{ $member->nik }}"
                                                       required data-validation-required-message="This NIK field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" placeholder="Alamat"
                                                      required data-validation-required-message="This Phone field is required">{{ $member->address }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Nomor Telepon" value="{{ $member->phone }}"
                                                   required data-validation-required-message="This Phone field is required">
                                        </div>
                                        <div class="form-group">
                                            <label>TUPO</label>
                                            <input type="text" class="form-control" value="{{ $member->close_point_date == null ? '' : Carbon\Carbon::parse($member->close_point_date)->format('d-M-y') }}" readonly
                                                   placeholder="Tanggal TUPO">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" value="" placeholder="Password" />
                                            <button type="button" id="btn-pass">Show</button>
                                            <span id="hide_pass" style="display: none">{{ $kucing->ikan_asin }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Negara</label>
                                            <select class="form-control" name="country_id" id="country_id">
                                                <option></option>
                                                @foreach($countries as $country)
                                                    @if($country->id == $member->country_id)
                                                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                                    @else
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Propinsi</label>
                                            <select class="form-control" name="province_id" id="province_id">
                                                <option></option>
                                                @foreach($provinces as $province)
                                                    @if($province->id == $member->province_id)
                                                        <option value="{{ $province->id }}" selected>{{ $province->name }}</option>
                                                    @else
                                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <select class="form-control" name="city_id" id="city_id">
                                                <option></option>
                                                @foreach($cities as $city)
                                                    @if($city->id == $member->city_id)
                                                        <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                                    @else
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>BANK</label>
                                            <input type="text" class="form-control" name="bank" value="{{ $member->bank }}" placeholder="BANK" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Rekening</label>
                                            <input type="text" class="form-control" name="account_number" value="{{ $member->account_number }}" placeholder="Nomor Rekening" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama pada Rekening</label>
                                            <input type="text" class="form-control" name="account_name" value="{{ $member->account_name }}" placeholder="Nama pada Rekening" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Level</label>
                                            <input type="text" class="form-control" value="{{ $member->level == null ? '' : $member->level->name }}" placeholder="Pilih Level" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Sponsor</label>
                                            <input type="text" class="form-control" value="{{ $member->sponsor == null ? '' : $member->sponsor->code . ' - ' . $member->sponsor->name }}" placeholder="Pilih Sponsor" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Upline</label>
                                            <input type="text" class="form-control" value="{{ $member->upLine == null ? '' : $member->upLine->code . ' - ' . $member->upLine->name }}" placeholder="Pilih Upline" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Downline Kiri</label>
                                            <input type="text" class="form-control" value="{{ $member->leftDownLine == null ? '' : $member->leftDownLine->code . ' - ' . $member->leftDownLine->name }}" placeholder="Pilih Downline Kiri" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Downline Kanan</label>
                                            <input type="text" class="form-control" value="{{ $member->rightDownLine == null ? '' : $member->rightDownLine->code . ' - ' . $member->rightDownLine->name }}" placeholder="Pilih Downline Kanan" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                                        <button type="reset" class="btn btn-outline-warning">Reset</button>
                                    </div>
                                </div>
                            </form>
                            <!-- users edit account form ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users edit ends -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/admins/user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection

