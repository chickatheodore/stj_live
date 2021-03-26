@extends('layouts/contentLayoutMaster')

@section('title', 'Profil')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/noui-slider.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/core/colors/palette-noui.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/toastr.css')) }}">
@endsection

@section('content')
    <!-- account setting page start -->
    <section id="account-settings">
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill"
                           href="#account-vertical-general" aria-expanded="true">
                            <i class="feather icon-globe mr-50 font-medium-3"></i>
                            Umum
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75" id="account-pill-password" data-toggle="pill"
                           href="#account-vertical-password" aria-expanded="false">
                            <i class="feather icon-lock mr-50 font-medium-3"></i>
                            Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75" id="account-pill-info" data-toggle="pill" href="#account-vertical-info"
                           aria-expanded="false">
                            <i class="feather icon-info mr-50 font-medium-3"></i>
                            Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75" id="account-pill-notifications" data-toggle="pill"
                           href="#account-vertical-notifications" aria-expanded="false">
                            <i class="feather icon-message-circle mr-50 font-medium-3"></i>
                            Notifikasi
                        </a>
                    </li>
                </ul>
            </div>
            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                     aria-labelledby="account-pill-general" aria-expanded="true">
                                    <form method="post" id="form-general">
                                        <div class="row">
                                            <div class="col-12 row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-code">Member ID</label>
                                                            <input type="text" class="form-control" id="account-code" placeholder="Member ID" value="{{ $member->code }}" required
                                                                   data-validation-required-message="This member id field is required" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 hidden">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-username">Username</label>
                                                            <input type="text" class="form-control" id="account-username" placeholder="Username" value="{{ $member->username }}" required
                                                                   data-validation-required-message="This username field is required" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-name">Name</label>
                                                        <input type="text" class="form-control" id="account-name" placeholder="Name"
                                                               value="{{ $member->name }}" required
                                                               data-validation-required-message="This name field is required" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="level_id">Level</label>
                                                        @php
                                                        $dis = $member->level_id == 2 ? 'disabled' : '';
                                                        @endphp
                                                        <select class="form-control level_id" name="level_id" id="level_id" {{ $dis }}>
                                                            <option value=""></option>
                                                            @foreach($levels as $level)
                                                                @if($member->level_id == $level->id)
                                                                    <option value="{{ $level->id }}" selected>{{ $level->name }}</option>
                                                                @else
                                                                    <option value="{{ $level->id }}" {{ $member->pin < $level->minimum_point ? ' disabled="disabled"' : '' }}>{{ $level->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-e-mail">E-mail</label>
                                                            <input type="email" class="form-control" id="account-e-mail" placeholder="Email"
                                                                   value="{{ $member->email }}" required
                                                                   data-validation-required-message="This email field is required" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-pin">Sisa PIN</label>
                                                            <input type="text" class="form-control" id="account-pin" placeholder="Sisa PIN"
                                                                   value="{{ $member->pin }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-bonus_point">Bonus Poin</label>
                                                            <input type="text" class="form-control" id="account-bonus_point" placeholder="Bonus Poin"
                                                                   value="{{ number_format($member->left_bonus_point, 0) }} | {{ number_format($member->right_bonus_point, 0) }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="account-bonus_partner">Bonus Pasangan</label>
                                                            <input type="text" class="form-control" id="account-bonus_partner" placeholder="Bonus Pasangan"
                                                                   value="{{ number_format($member->left_bonus_partner, 0) }} | {{ number_format($member->right_bonus_partner, 0) }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" id="btn-save-level" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                                <button type="reset" class="btn btn-outline-warning" disabled>Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel"
                                     aria-labelledby="account-pill-password" aria-expanded="false">
                                    <form id="form-account" method="post" action="{{ route('member.profile.account') }}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-old-password">Old Password</label>
                                                        <input type="password" class="form-control" id="account-old-password" required
                                                               name="old_password"
                                                               placeholder="Old Password"
                                                               data-validation-required-message="This old password field is required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-new-password">New Password</label>
                                                        <input type="password" name="password" id="account-new-password" class="form-control"
                                                               placeholder="New Password" required
                                                               data-validation-required-message="The password field is required" minlength="6">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-retype-new-password">Retype New
                                                            Password</label>
                                                        <input type="password" name="con_password" class="form-control" required
                                                               id="account-retype-new-password" data-validation-match-match="password"
                                                               placeholder="New Password"
                                                               data-validation-required-message="The Confirm password field is required" minlength="6">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-sponsor_id">Sponsor</label>
                                                        <select class="form-control sponsor_id" id="account-sponsor_id" name="sponsor_id" disabled>
                                                            <option value=""></option>
                                                            @foreach($allMembers as $currMember)
                                                                @if($member->sponsor_id == $currMember->id)
                                                                    <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                                @else
                                                                    <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-upline_id">Upline</label>
                                                    <select class="form-control upline_id" id="account-upline_id" name="upline_id" disabled>
                                                        <option value=""></option>
                                                        @foreach($allMembers as $currMember)
                                                            @if($member->upline_id == $currMember->id)
                                                                <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                            @else
                                                                <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-left_downline_id">Downline</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select class="form-control left_downline_id" id="account-left_downline_id" name="left_downline_id" disabled>
                                                                <option value=""></option>
                                                                @foreach($allMembers as $currMember)
                                                                    @if($member->left_downline_id == $currMember->id)
                                                                        <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                                    @else
                                                                        <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control right_downline_id" id="account-right_downline_id" name="right_downline_id" disabled>
                                                                <option value=""></option>
                                                                @foreach($allMembers as $currMember)
                                                                    @if($member->right_downline_id == $currMember->id)
                                                                        <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                                    @else
                                                                        <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="button" id="btn-save-account" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                                <button type="reset" class="btn btn-outline-warning">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info"
                                     aria-expanded="false">
                                    <form method="post" id="form-info" action="{{ route('member.profile.info') }}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-nik">NIK</label>
                                                        <input type="text" class="form-control nik" required placeholder="NIK" id="account-nik" name="nik" value="{{ $member->nik }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-address">Address</label>
                                                    <textarea class="form-control address" id="account-address" name="address" rows="3" placeholder="Your Address data here...">{{ $member->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-country_id">Country</label>
                                                    <select class="form-control country_id" id="account-country_id" name="country_id">
                                                        <option>Pilih negara</option>
                                                        @foreach($countries as $country)
                                                            @if($member->country_id == $country->id)
                                                                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                                            @else
                                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-province_id">Province</label>
                                                    <select class="form-control province_id" id="account-province_id" name="province_id">
                                                        <option>Pilih propinsi</option>
                                                        @foreach($provinces as $province)
                                                            @if($member->province_id == $province->id)
                                                                <option value="{{ $province->id }}" selected>{{ $province->name }}</option>
                                                            @else
                                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="account-city_id">City</label>
                                                    <select class="form-control city_id" id="account-city_id" name="city_id">
                                                        <option>Pilih kota</option>
                                                        @foreach($cities as $city)
                                                            @if($member->city_id == $city->id)
                                                                <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                                            @else
                                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-phone">Phone</label>
                                                        <input type="text" class="form-control" id="account-phone" required placeholder="Phone number"
                                                               value="{{ $member->phone }}" name="phone"
                                                               data-validation-required-message="This phone number field is required">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-bank">Bank</label>
                                                        <input type="text" class="form-control" id="account-bank" required placeholder="Bank"
                                                               value="{{ $member->bank }}" name="bank"
                                                               data-validation-required-message="This bank field is required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-account_number">No. Rekening</label>
                                                        <input type="text" class="form-control account_number" id="account-account_number" required placeholder="Nomor Rekening"
                                                               value="{{ $member->account_number }}" name="account_number"
                                                               data-validation-required-message="This account number field is required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-account_name">Nama Nasabah</label>
                                                        <input type="text" class="form-control account_name" id="account-account_name" required placeholder="Nama Nasabah"
                                                               value="{{ $member->account_name }}" name="account_name"
                                                               data-validation-required-message="This account name field is required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" id="btn-save-info" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                                <button type="reset" class="btn btn-outline-warning">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="account-vertical-notifications" role="tabpanel"
                                     aria-labelledby="account-pill-notifications" aria-expanded="false">
                                    <div class="row">
                                        <h6 class="m-1">Activity</h6>
                                        <div class="col-12 mb-1">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch1">
                                                <label class="custom-control-label mr-1" for="accountSwitch1"></label>
                                                <span class="switch-label w-100">Email me when someone comments on my article</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch2">
                                                <label class="custom-control-label mr-1" for="accountSwitch2"></label>
                                                <span class="switch-label w-100">Email me when someone answers on my form</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="accountSwitch3">
                                                <label class="custom-control-label mr-1" for="accountSwitch3"></label>
                                                <span class="switch-label w-100">Email me hen someone follows me</span>
                                            </div>
                                        </div>
                                        <h6 class="m-1">Application</h6>
                                        <div class="col-12 mb-1">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch4">
                                                <label class="custom-control-label mr-1" for="accountSwitch4"></label>
                                                <span class="switch-label w-100">News and announcements</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="accountSwitch5">
                                                <label class="custom-control-label mr-1" for="accountSwitch5"></label>
                                                <span class="switch-label w-100">Weekly product updates</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" checked id="accountSwitch6">
                                                <label class="custom-control-label mr-1" for="accountSwitch6"></label>
                                                <span class="switch-label w-100">Weekly blog digest</span>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                changes</button>
                                            <button type="reset" class="btn btn-outline-warning">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="_acc_" name="_acc_" value="{{ auth()->id() }}" />
    </section>
    <!-- account setting page end -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/members/profile.js')).'?v='.date('Ymdhis') }}"></script>
    <script type="text/javascript">
        let m_p = {{ $member->pin }};
        let m_l = {{ $member->level_id }};
    </script>
@endsection
