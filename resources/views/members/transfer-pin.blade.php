@extends('layouts/contentLayoutMaster')

@section('title', 'Transfer PIN')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/toastr.css')) }}">
@endsection

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" id="form-transfer-pin" method="POST">
                    @csrf

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Transfer PIN</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            <div class="form-group">
                                                <label for="member_id">Transfer ke Member</label>
                                                <select class="form-control member_id" id="member_id" name="member_id">
                                                    <option value=""></option>
                                                    @foreach($allMembers as $currMember)
                                                    <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <hr />

                                            <div class="form-group">
                                                <label for="amount">Jumlah PIN yang akan ditransfer</label>
                                                <input type="number" class="form-control touchspin-min-max" id="amount" name="amount" value="0">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <button type="submit" id="btn-save" class="btn btn-primary float-right btn-inline mb-50" disabled>Transfer PIN</button>
                                    <input type="hidden" id="_acc_" name="_acc_" value="{{ auth()->id() }}">
                                </div>
                            </div>
                            <div class="col-md-3"></div>
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
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->

    <script type="text/javascript">
        var mySelf = {{ $member->id }};
        var counterMin = 0;
        var counterMax = {{ $member->pin }};
    </script>

    <script src="{{ asset(mix('js/scripts/members/transfer-pin.js')) }}"></script>
@endsection
