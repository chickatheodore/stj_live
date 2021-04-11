/*=========================================================================================
	File Name: account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {

    // Member select
    var memberselect = $("#member_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih member',
        allowClear: true
    });

});

$("#member_id").change(function (e) {

    let mId = $('#member_id option:selected').val();

    $('#btn-save').prop('disabled', !mId);
});

$('#btn-save').click(function (e) {
    e.preventDefault();

    let mId = $('#member_id option:selected').val();
    if (!mId) {
        Swal.fire({
            title: "Warning!",
            text: 'Silahkan pilih member yang akan di transfer!',
            type: "warning",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated tada',
        });
        return;
    }

    let amount = $('#amount').val();
    let jumlah = parseInt(amount);
    if (jumlah <= 0) {
        Swal.fire({
            title: "Warning!",
            text: 'Masukkan jumlah pin, minimal 1 !',
            type: "warning",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated tada',
        });
        return;
    }

    let _data = $('#form-transfer-pin').serializeArray();

    _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

    $.ajaxSetup({
        type: "POST",
        url: "/admin/trf-pin",
        headers: addAuthHeader()
    });

    showSTJModal();
    $.ajax({ data: _data })
        .fail(function() {
            hideSTJModal();
            Swal.fire({
                title: "Warning!",
                text: 'Proses transfer PIN gagal!',
                type: "warning",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
                animation: false,
                customClass: 'animated tada',
            });
        })
        .done(function( result ) {
            hideSTJModal();
            const me = JSON.parse(result);
            if (me.status) {
                Swal.fire({
                    title: "Transfer PIN",
                    text: "PIN telah berhasil ditransfer!",
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
