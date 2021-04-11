/*=========================================================================================
	File Name: account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

let _buttonSave = $('#btn-save');

$(document).ready(function () {

    _setLoadingButton(_buttonSave);
    // Member select
    var memberselect = $("#member_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih member',
        allowClear: true
    });

    disableMySelf();
    //initSpinner();

});

function initSpinner() {

    var touchspinValue = $(".touchspin-min-max");
    if (touchspinValue.length > 0) {
        touchspinValue.TouchSpin({
            min: counterMin,
            max: counterMax
        }).on('touchspin.on.startdownspin', function () {
            var $this = $(this);
            $('.bootstrap-touchspin-up').removeClass("disabled-max-min");
            if ($this.val() == counterMin) {
                $(this).siblings().find('.bootstrap-touchspin-down').addClass("disabled-max-min");
            }
        }).on('touchspin.on.startupspin', function () {
            var $this = $(this);
            $('.bootstrap-touchspin-down').removeClass("disabled-max-min");
            if ($this.val() == counterMax) {
                $(this).siblings().find('.bootstrap-touchspin-up').addClass("disabled-max-min");
            }
        });
    }
}

function disableMySelf() {
    $('#member_id option[value=' + mySelf + ']').attr('disabled', 'disabled');
}

$("#member_id").change(function (e) {

    let mId = $('#member_id option:selected').val();

    _buttonSave.prop('disabled', !mId);
});

_buttonSave.click(function (e) {
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
    if (jumlah <= 0 || jumlah > counterMax){
        Swal.fire({
            title: "Warning!",
            text: 'Masukkan angka dari 1 sampai dengan ' + counterMax + '!',
            type: "warning",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated tada',
        });
        return;
    }

    loadingButtonSTJ('Transfer', true);

    let _data = $('#form-transfer-pin').serializeArray();

    _data.push({'name': '_acc_', 'value': $('#_acc_').val()});
    _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

    $.ajaxSetup({
        type: "POST",
        url: "/member/transferPin",
        headers: addAuthHeader()
    });

    $.ajax({ data: _data })
        .fail(function() {
            loadingButtonSTJ(null, false);
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
            loadingButtonSTJ(null, false);
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
