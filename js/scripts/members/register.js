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
    initCitySelect();

    $('#province_id').change(function (e) {
        let id = $(this).val();
        if (!id)
            renderCities(0);
        else
            renderCities(parseInt(id));
    });

});

function initCitySelect() {
    $("#city_id").select2({
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: 'Pilih kota / kabupaten',
        allowClear: true
    });
}

function renderCities(provId) {
    $('#city_id').empty();
    $('#city_id').append('<option value=""></option>');

    if (provId === 0) {
        initCitySelect();
        return;
    }

    const cities = _city_data.filter(city => city.province_id === provId);

    cities.forEach(function (city) {
        $('#city_id').append('<option value="' + city.id + '" data-prov="' + city.province_id + '">' + city.name + '</option>');
    });

    initCitySelect();
}
