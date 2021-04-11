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

    //Level select
    initLevelSelect2();

    // Sponsor select
    initSponsorSelect2();

    // Upline select
    initUplineSelect2();

});

function initLevelSelect2() {
    $("#level_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih level',
        allowClear: true
    });
}

function initSponsorSelect2() {
    $("#sponsor_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih sponsor',
        allowClear: true
    });
}

function initUplineSelect2() {
    $("#upline_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih upline',
        allowClear: true
    });
}

$("#member_id, #sponsor_id").change(function (e) {
    var id = $('#upline_id option:selected').val(),
        sId = $('#sponsor_id option:selected').val(),
        mId = $('#member_id option:selected').val();

    if (sId === mId) {
        $('#sponsor_id').val('');
        $('#btn-save').prop('disabled', false);
        Swal.fire({
            title: "Warning!",
            text: " Sponsor tidak boleh sama dengan pilihan di member baru!",
            type: "warning",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated tada',
        });
        return;
    }

    $('#btn-save').prop('disabled', !id && (!sId || !mId));

    if ($(this).attr('id') === 'member_id')
        checkMember(mId);
});

$("#upline_id").change(function (e) {
    var bSave = $('#btn-save');
    var id = $('#upline_id option:selected').val(),
        mId = $('#member_id option:selected').val();

    if (mId === id) {
        $('#upline_id').val('');
        bSave.prop('disabled', false);
        Swal.fire({
            title: "Warning!",
            text: " Upline tidak boleh sama dengan pilihan di member baru!",
            type: "warning",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated tada',
        });
        return;
    }

    var pohonKiri = $('#pohonKiri'),
        pohonKanan = $('#pohonKanan');

    pohonKiri.prop('checked', false);
    pohonKanan.prop('checked', false);

    $('#labelKiri').html('A<br />Tersedia');
    $('#labelKanan').html('B<br />Tersedia');

    if (!id) {
        pohonKiri.prop('disabled', true);
        pohonKanan.prop('disabled', true);

        var spon = $('#sponsor_id').val();
        if (!spon)
            bSave.prop('disabled', true);
        return;
    }

    pohonKiri.prop('disabled', false);
    pohonKanan.prop('disabled', false);
    bSave.prop('disabled', false);

    showSTJModal();
    $.ajaxSetup({
        type: "GET",
        headers: addAuthHeader()
    });

    $.ajax({
        url: "/member/getMember/" + id,
    })
        .done(function( data ) {
            //hideSTJModal();
            hideSTJModal();
            var member = JSON.parse(data);

            var left = null, right = null;

            if (member.left_downline_id) {
                left = JSON.parse(member.left_downline);
                pohonKiri.prop('disabled', true);
                $('#labelKiri').html(left.code + '<br />' + left.name);
            }

            if (member.right_downline_id) {
                right = JSON.parse(member.right_downline);
                pohonKanan.prop('disabled', true);
                $('#labelKanan').html(right.code + '<br />' + right.name);
            }

            if (member.left_downline_id && member.right_downline_id) {
                $('#upline_id').val('');
                bSave.prop('disabled', true);

                Swal.fire({
                    title: "Warning!",
                    text: " Member ini sudah mempunyai downline berpasangan!",
                    type: "warning",
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                    animation: false,
                    customClass: 'animated tada',
                });
            }

        });
});

function checkMember(mId) {
    //Pastikan member baru disable di Sponsor dan Upline
    $("#sponsor_id option[value=" + mId + "]").attr('disabled', 'disabled')
        .siblings().removeAttr('disabled');

    $("#upline_id option[value=" + mId + "]").attr('disabled', 'disabled')
        .siblings().removeAttr('disabled');

    initSponsorSelect2();
    initUplineSelect2();

    //Cek jika punya point
    //var level = $('#level_id').val();
    //if (!level) return;

    $('#level_id').attr('disabled', 'disabled');
    showSTJModal();
    $.ajaxSetup({
        type: "GET",
        headers: addAuthHeader()
    });

    $.ajax({
        url: "/member/getPoint/" + mId,
    })
    .done(function( data ) {
        //hideSTJModal();
        hideSTJModal();
        let result = JSON.parse(data);
        let member = result.member;

        $('#level_id').removeAttr('disabled');
        $('.level-hide').html('Jumlah PIN : ' + member.pin);

        // Member GOLD tidak bisa downgrade
        if (member.level_id === 2)
            $('#level_id').attr('disabled', 'disabled');

        disableLevel(result.levels, member.pin);

        //Cek apakah sudah punya sponsor ataupun upline
        if (member.sponsor_id)
            disableSelectAndSetValue('sponsor_id', member.sponsor_id);
        if (member.upline_id)
            disableSelectAndSetValue('upline_id', member.upline_id);
    });

}

function disableLevel(levels, point) {
    $('#level_id option').prop('disabled', false);

    for (let i = 0; i < levels.length; i++) {
        var l = levels[i];
        var e = $('#level_id option[value=' + l.id + ']');
        if (point < l.minimum_point)
            e.attr('disabled', 'disabled');
    }
}

function disableSelectAndSetValue(id, value)
{
    let select = $('#' + id);
    select.val(value).trigger('change');
    select.attr('disabled', 'disabled');
}
