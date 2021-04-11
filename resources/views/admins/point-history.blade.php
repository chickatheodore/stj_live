@extends('layouts/contentLayoutMaster')

@section('title', 'Point History')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" id="form-history" method="POST">
                    @csrf

                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Point History</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        @php
                                        $current = Carbon\Carbon::now();
                                        $start_date = Carbon\Carbon::create($current->year, $current->month, 1, 0);
                                        $end_date = Carbon\Carbon::create($current->year, $current->month, 1, 0)->addMonth()->subDay();
                                        @endphp
                                        <div class="card-body pt-0">

                                            <div class="form-group">
                                                <label for="start_date">Periode Transaksi</label>
                                                <input type="text" id="start_date" name="start_date" class="form-control start-date-picker" required placeholder="Start date"
                                                       value="{{ $start_date->format('d-M-Y') }}"
                                                       data-validation-required-message="This start date field is required">
                                            </div>

                                            <div class="form-group">
                                                <label for="amount"></label>
                                                <input type="text" id="end_date" name="end_date" class="form-control end-date-picker" required placeholder="End date"
                                                       value="{{ $end_date->format('d-M-Y') }}"
                                                       data-validation-required-message="This end date field is required">

                                            </div>

                                            <div class="form-group d-flex justify-content-center">
                                                <button type="button" id="btn-show" class="btn btn-primary float-right btn-inline mb-50">Tampilkan Data</button>
                                                <input type="hidden" id="_acc_" name="_acc_" value="{{ auth()->id() }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <table id="bonustable" class="table table-bordered mt-2 small">
                                        <thead>
                                        <tr>
                                            <th class="text-center align-middle">Tgl</th>
                                            <th class="text-center align-middle">Member</th>
                                            <th class="text-center align-middle" style="min-width: 50px">Poin</th>
                                            <th class="text-center align-middle" style="min-width: 60px">Poin Balance</th>
                                            <th class="text-center align-middle">Bonus Poin</th>
                                            <th class="text-center align-middle">Bonus Sponsor</th>
                                            <th class="text-center align-middle">Bonus Dibayar</th>
                                            <th class="text-center align-middle">Saldo Bonus</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
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
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#start_date').pickadate({
                format: 'dd-mmm-yyyy'
            });
            $('#end_date').pickadate({
                format: 'dd-mmm-yyyy'
            });
        });

        $('#btn-show').click(function (e) {
            let _data = $('#form-history').serializeArray();
            //_data.push({'name': '_acc_', 'value': $('#_acc_').val()});
            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            showSTJModal();

            $.ajaxSetup({
                type: "GET",
                url: "/admin/getPointHistory",
                headers: addAuthHeader()
            });

            $.ajax({ data: _data })
            .fail(function (e) {

            })
            .done(function( data ) {
                hideSTJModal();
                var histories = JSON.parse(data);

                $('#bonustable tbody').empty();
                for (let i = 0; i < histories.length; i++) {
                    let item = histories[i];
                    $('#bonustable tbody').append('<tr>' +
                        '<td>' + item.transaction_date + '</td>' +
                        '<td>' + item.member_name + '</td>' +
                        '<td>' + $.number(item.left_point_amount) + ' | ' + $.number(item.right_point_amount) + '</td>' +
                        '<td>' + $.number(item.left_point_ending_balance) + ' | ' + $.number(item.right_point_ending_balance) + '</td>' +
                        '<td>' + $.number(item.bonus_point_amount) + '</td>' +
                        '<td>' + $.number(item.bonus_sponsor_amount) + '</td>' +
                        '<td>' + $.number(item.bonus_paid_amount) + '</td>' +
                        '<td>' + $.number(item.bonus_ending_balance) + '</td>' +
                        '</tr>');
                }
            });

        });
    </script>
@endsection
