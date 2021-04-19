@extends('layouts/contentLayoutMaster')

@section('title', 'Historical Bonus')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('content')
    <style rel="stylesheet">
        #bonustable { font-size: 80%; }
    </style>
    <section id="register-layout">

        <!-- ================================================= -->
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" id="form-history" method="POST">
                    @csrf

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Historical Bonus</h4>
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

                                        <div class="col-md-12 col-12 table-responsive">

                                            <table id="bonustable" class="table table-sm table-striped table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center align-middle" style="min-width:100px;">Tgl</th>
                                                    <th class="text-center align-middle" style="min-width: 100px">Poin</th>
                                                    <th class="text-center align-middle" style="min-width: 100px">Pencairan</th>
                                                    <th class="text-center align-middle" style="min-width: 100px">Poin Balance</th>
                                                    <!-- <th class="text-center align-middle">Bonus Poin</th> -->
                                                    <th class="text-center align-middle">Bonus Sponsor</th>
                                                    <th class="text-center align-middle">Bonus Pasangan</th>
                                                    <th class="text-center align-middle">Bonus Dibayar</th>
                                                    <th class="text-center align-middle">Saldo Bonus</th>
                                                    <th class="text-center align-middle">Keterangan</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">&nbsp;</div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- ================================================= -->

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
                                    <textarea class="form-control" id="remark_input" rows="5" readonly="readonly" style="font-size: 85%;"></textarea>
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
            
            showBonusHistory();
        });

        $('#btn-show').click(function (e) {
            showBonusHistory();
        });

        function showBonusHistory() {
            let _data = $('#form-history').serializeArray();
            _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            showSTJModal();

            $.ajaxSetup({
                type: "POST",
                url: "/member/getBonusHistory",
                headers: addAuthHeader()
            });

            $.ajax({ data: _data })
                .fail(function (e) {
                    hideSTJModal();

                    Swal.fire({
                        title: "Warning!",
                        text: "Terjadi kesalahan pada saat memproses.",
                        type: "warning",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                        animation: false,
                        customClass: 'animated tada',
                    });
                })
                .done(function( data ) {
                    hideSTJModal();
                    var histories = JSON.parse(data);

                    $('#bonustable tbody').empty();
                    for (let i = 0; i < histories.length; i++) {
                        let item = histories[i];
                        let _id = 'bonus_' + i;
                        $('#bonustable tbody').append('<tr id="' + _id + '" style="cursor: pointer" onclick="showRemarks(\'' + _id + '\')">' +
                            '<td>' + item.transaction_date + '</td>' +
                            '<td class="text-center">' + $.number(item.left_point_in) + ' | ' + $.number(item.right_point_in) + '</td>' +
                            '<td class="text-center">' + $.number(item.left_point_out) + ' | ' + $.number(item.right_point_out) + '</td>' +
                            '<td class="text-center">' + $.number(item.left_point_ending_balance) + ' | ' + $.number(item.right_point_ending_balance) + '</td>' +
                            //'<td class="text-right">' + $.number(item.bonus_point_amount) + '</td>' +
                            '<td class="text-right">' + $.number(item.bonus_sponsor_amount) + '</td>' +
                            '<td class="text-right">' + $.number(item.bonus_partner_amount) + '</td>' +
                            '<td class="text-right">' + $.number(item.bonus_paid_amount) + '</td>' +
                            '<td class="text-right">' + $.number(item.bonus_ending_balance) + '</td>' +
                            '<td class="text-right"><button type="button" class="btn btn-info" onclick="showRemarks(\'' + _id + '\')">Keterangan</button></td>' +
                            '</tr>');

                        $("tr#" + _id).data('bonus', item);
                    }
                });
        }

        function showRemarks(el) {
            let _bonus = $('tr#' + el).data('bonus');
            $('#remark_input').html(_bonus.remarks);
            $('#remarks-modal').modal('show');
        }
    </script>
@endsection
