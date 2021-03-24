/*=========================================================================================
	File Name: account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {

    // Country select
    var countryselect = $("#country_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih negara',
        allowClear: true
    });

    // Province select
    var provinceselect = $("#province_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih propinsi',
        allowClear: true
    });

    // City select
    var cityselect = $("#city_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih kota / kabupaten',
        allowClear: true
    });

});
