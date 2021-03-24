@extends('layouts/contentLayoutMaster')

@section('title', 'Perpanjang TUPO')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">

                <form class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card text-center">
                                    <div class="card-header pt-50 pb-1" style="display: block">
                                        <div class="card-title">
                                            <h4 class="mb-0">Perpanjang Masa Berakhir TUPO</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            @if ($member->id <= 1)
                                            <div class="alert alert-warning" role="alert">
                                                <h4 class="alert-heading">Administrator</h4>
                                                <p class="mb-0">
                                                    Akun anda tidak perlu melakukan proses perpanjang masa berkhir TUPO.
                                                </p>
                                            </div>
                                            @else
                                                @if ($member->pin >= 1)
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <span id="info-pin" style="background-color: #262c49;padding: 8px;">PIN Tersisa : {{ number_format($member->pin, 0) }}</span>
                                                    <div>&nbsp;</div>
                                                    <span style="background-color: #262c49;padding: 8px;">Masa Berlaku : {{ Carbon\Carbon::parse($member->close_point_date)->format('d-M-Y') }}</span>
                                                </div>
                                                <div>&nbsp;</div>
                                                <input type="hidden" id="_acc_" name="_acc_" value="{{ auth()->id() }}">
                                                <button type="button" id="btn-extend" class="btn btn-primary">Perpanjang</button>
                                            </div>
                                                @else
                                            <div class="alert alert-warning text-align-center" role="alert">
                                                <h4 class="alert-heading">Warning</h4>
                                                <p class="mb-0">
                                                    STOCK PIN REGISTRASI anda tidak tersedia.
                                                </p>
                                            </div>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
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
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script type="text/javascript">
        $('#btn-extend').click(function (e) {
            let _data = [];

            _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            $.ajaxSetup({
                type: "POST",
                url: "/member/extend",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({ data: _data })
                .fail(function() {
                    Swal.fire({
                        title: "Warning!",
                        text: 'Proses Perpanjang Masa Berlaku TUPO gagal!',
                        type: "warning",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                        animation: false,
                        customClass: 'animated tada',
                    });
                })
                .done(function( result ) {
                    const me = JSON.parse(result);
                    if (me.status) {
                        $('#info-pin').html('PIN Tersisa : ' + $.number(me.pin));

                        Swal.fire({
                            title: "Sukses",
                            text: me.message,
                            type: "success",
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                        });
                    } else {
                        Swal.fire({
                            title: "Warning!",
                            text: me.message,
                            type: "warning",
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false,
                            animation: false,
                            customClass: 'animated tada',
                        });
                    }
                });
        });
    </script>
@endsection
