@extends('layouts/contentLayoutMaster')

@section('title', 'Upgrade Level')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">

                <form class="form form-horizontal" id="form-upgrade">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card text-center">
                                    <div class="card-header pt-50 pb-1" style="display: block">
                                        <div class="card-title">
                                            <h4 class="mb-0">Upgrade Level</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            @if ($member->level_id == 2)
                                            <div class="alert alert-warning text-align-center" role="alert">
                                                <h4 class="alert-heading">Warning</h4>
                                                <p class="mb-0">
                                                    Level anda sudah GOLD, anda tidak bisa mengubah lagi.
                                                </p>
                                            </div>
                                            @elseif (($member->level_id == null || $member->level_id == 1) && $member->pin < 1)
                                            <div class="alert alert-warning text-align-center" role="alert">
                                                <h4 class="alert-heading">Warning</h4>
                                                <p class="mb-0">
                                                    <div>PIN Registrasi anda tidak mencukupi untuk proses upgrade.</div>
                                                <div>&nbsp;</div>
                                                <div class="text-center">
                                                    <span id="info-pin" style="background-color: #262c49;padding: 8px;">PIN Tersisa : {{ number_format($member->pin, 0) }}</span>
                                                </div>
                                                </p>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <span id="info-pin" style="background-color: #262c49;padding: 8px;">PIN Tersisa : {{ number_format($member->pin, 0) }}</span>
                                                </div>
                                                <div>&nbsp;</div>
                                                <select id="level_id" name="level_id">
                                                    <option></option>
                                                        @php
                                                        foreach($levels as $level)
                                                        {
                                                            $pin_less = $member->pin < $level->minimum_point;
                                                            $current = $member->level_id === $level->id;
                                                            $disa = ($pin_less || $current) ? ' disabled' : '';
                                                            echo '<option value="' . $level->id . '"' . $disa . '>' . $level->name . '</option>';
                                                        }
                                                        @endphp
                                                </select>
                                                <div>&nbsp;</div>
                                                <input type="hidden" id="_acc_" name="_acc_" value="{{ auth()->id() }}">
                                                <button type="button" id="btn-extend" class="btn btn-primary" disabled>Upgrade</button>
                                            </div>
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
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#level_id').select2({
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: 'Pilih level member',
                allowClear: true
            });
        });

        $('#btn-extend').click(function (e) {
            $('#btn-extend').prop('disabled', true);
            $('#modal-backdrop').modal('show');

            let _data = $('#form-upgrade').serializeArray();

            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            $.ajaxSetup({
                type: "POST",
                url: "/member/upgradeLevel",
                headers: addAuthHeader()
            });

            $.ajax({ data: _data })
                .fail(function() {
                    $('#modal-backdrop').modal('hide');
                    $('#btn-extend').prop('disabled', false);

                    Swal.fire({
                        title: "Warning!",
                        text: 'Proses Upgrade Level gagal!',
                        type: "warning",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                        animation: false,
                        customClass: 'animated tada',
                    });
                })
                .done(function( result ) {
                    $('#modal-backdrop').modal('hide');
                    $('#level_id').prop('disabled', true);

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

        $('#level_id').change(function (e) {
            let level_val = $('#level_id option:selected').val();
            let level = parseInt(level_val);

            $('#btn-extend').prop('disabled', !level_val);
        })
    </script>
@endsection
