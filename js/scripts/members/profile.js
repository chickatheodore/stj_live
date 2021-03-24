/*=========================================================================================
	File Name: account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {
    // Level select
    var levelselect = $("#level_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih level keanggotaan',
        allowClear: true
    });

    // Sponsor select
    var sponsorselect = $("#account-sponsor_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih sponsor',
        allowClear: true
    });

    // Upline select
    var uplineselect = $("#account-upline_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih upline',
        allowClear: true
    });

    // Sponsor select
    var left_downlineselect = $("#account-left_downline_id").select2({
        dropdownAutoWidth: true,
        width: '50%',
        placeholder: 'Pilih downline sebelah kiri',
        allowClear: true
    });

    // Sponsor select
    var right_downlineselect = $("#account-right_downline_id").select2({
        dropdownAutoWidth: true,
        width: '50%',
        placeholder: 'Pilih downline sebelah kanan',
        allowClear: true
    });

    // Country select
    var countryselect = $("#account-country_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih negara',
        allowClear: true
    });

    // Province select
    var provinceselect = $("#account-province_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih propinsi',
        allowClear: true
    });

    // City select
    var cityselect = $("#account-city_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih kota',
        allowClear: true
    });

    // birthdate date
    /*$('.birthdate-picker').pickadate({
      format: 'mmmm, d, yyyy'
    });*/
});

$('#level_id').change(function (e) {
    let lId = $('#level_id option:selected').val();
    if (m_l > 0 && !lId) {
        Swal.fire({
            title: "Warning!",
            text: 'Anda tidak bisa mengosongkan level anda!',
            type: "warning",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated tada',
        });
        $(this).val(m_l);
    }
});

$('#btn-save-level').click(function (e) {
    e.preventDefault();
    let _data = $('#form-general').serializeArray();

    _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
    _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

    $.ajaxSetup({
        type: "POST",
        url: "/member/upgradeLevel",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadingButton($('#btn-save-level'), 'Save changes', true);
    $.ajax({ data: _data })
        .fail(function() {
            loadingButton($('#btn-save-level'), 'Save changes', false);
            Swal.fire({
                title: "Warning!",
                text: 'Proses simpan gagal!',
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
                animation: false,
                customClass: 'animated tada',
            });
        })
        .done(function( result ) {
            loadingButton($('#btn-save-level'), 'Save changes', false);
            const me = JSON.parse(result);
            if (me.status) {
                toastr.success(me.message, 'Upgrade level', { "closeButton": true });
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

$('#btn-save-account').click(function (e) {
    e.preventDefault();
    var _data = $('#form-account').serializeArray();

    _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
    _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

    $.ajaxSetup({
        type: "POST",
        url: "/member/profileAccount",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadingButton($('#btn-save-account'), 'Save changes', true);
    $.ajax({ data: _data })
        .fail(function() {
            loadingButton($('#btn-save-account'), 'Save changes', false);
            Swal.fire({
                title: "Warning!",
                text: 'Proses simpan gagal!',
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
                animation: false,
                customClass: 'animated tada',
            });
        })
        .done(function( result ) {
            loadingButton($('#btn-save-account'), 'Save changes', false);
            const me = JSON.parse(result);
            if (me.status) {
                toastr.success(me.message, 'Password change', { "closeButton": true });
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

$('#btn-save-info').click(function (e) {
    e.preventDefault();
    var _data = $('#form-info').serializeArray();

    _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
    _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

    $.ajaxSetup({
        type: "POST",
        url: "/member/profileInfo",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadingButton($('#btn-save-info'), 'Save changes', true);
    $.ajax({ data: _data })
        .fail(function() {
            loadingButton($('#btn-save-info'), 'Save changes', false);
            Swal.fire({
                title: "Warning!",
                text: 'Proses simpan gagal!',
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
                animation: false,
                customClass: 'animated tada',
            });
        })
        .done(function( result ) {
            loadingButton($('#btn-save-info'), 'Save changes', false);
            const me = JSON.parse(result);
            if (me.status) {
                toastr.success(me.message, 'Info akun', { "closeButton": true });
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

function loadingButton(e, text, show) {
    if (show) {
        e.prop('disabled', true);
        e.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + text);
        $('#modal-backdrop').modal('show');
        $('#loader-text').html('Saving...');
    } else {
        e.prop('disabled', false);
        e.html(text);
        $('#modal-backdrop').modal('hide');
        $('#loader-text').html('Loading...');
    }
}
