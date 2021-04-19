@extends('layouts/contentLayoutMaster')

@section('title', 'PIN History')

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

                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">PIN History</h4>
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
                                <!-- =================== //-->
                                <div class="card">
                                    <div class="card-content">
                                        <div class="col-md-12 col-12 table-responsive">

                                            <table id="bonustable" class="table table-sm table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center align-middle">Tgl</th>
                                                    <th class="text-center align-middle">Member</th>
                                                    <th class="text-center align-middle" style="min-width: 50px">PIN</th>
                                                    <th class="text-center align-middle" style="min-width: 60px">PIN Balance</th>
                                                    <th class="text-center align-middle">Keterangan</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-- =================== //-->
                            </div>
                            <div class="col-md-3"></div>

                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="modal fade" id="remarks-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Remarks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="remark_input">Remarks</label>
                                    <textarea class="form-control" id="remark_input" rows="5" readonly="readonly"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            showSTJModal();

            $.ajaxSetup({
                type: "POST",
                url: "/admin/getPINHistory",
                headers: addAuthHeader()
            });

            $.ajax({ data: _data })
            .fail(function (e) {
                hideSTJModal();
            })
            .done(function( data ) {
                hideSTJModal();
                var histories = JSON.parse(data);

                $('#bonustable tbody').empty();
                for (let i = 0; i < histories.length; i++) {
                    let item = histories[i];
                    let _id = 'bonus_' + i;
                    $('#bonustable tbody').append('<tr id="' + _id + '">' +
                        '<td class="text-center">' + item.transaction_date + '</td>' +
                        '<td>' + item.member.code + ' - ' + item.member.name + '</td>' +
                        '<td class="text-center">' + $.number(item.pin_amount) + '</td>' +
                        '<td class="text-center">' + $.number(item.pin_ending_balance) + '</td>' +
                        '<td class="text-center"><button type="button" class="btn btn-info" onclick="showRemarks(\'' + _id + '\')">Keterangan</button></td>' +
                        '</tr>');

                    $("tr#" + _id).data('bonus', item);
                }
            });

        });

        function showRemarks(el) {
            let _pin = $('tr#' + el).data('bonus');
            $('#remark_input').html(_pin.remarks);
            $('#remarks-modal').modal('show');
        }
    </script>
@endsection
