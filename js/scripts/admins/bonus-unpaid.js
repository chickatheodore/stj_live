/*=========================================================================================
    File Name: app-user.js
    Description: User page JS
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function () {

    var isRtl;
    if ( $('html').attr('data-textdirection') == 'rtl' ) {
        isRtl = true;
    } else {
        isRtl = false;
    }

    /*function dateFormatter(params) {
        var dateAsString = params.data.Tanggal;
        var dateParts = dateAsString.split('/');
        return `${dateParts[0]} - ${dateParts[1]} - ${dateParts[2]}`;
    }*/
    function numericFormatter(params) {
        let id = params.colDef.field;
        if (id === 'BonusPoint' || id === 'BonusSponsor' || id === 'Total')
        {
            return $.number(params.value);
        }
        return params.value;
    }

    // ag-grid
    /*** COLUMN DEFINE ***/

    var columnDefs = [
        {
            headerName: 'ID',
            field: 'id',
            width: 125,
            filter: true,
            checkboxSelection: true,
            headerCheckboxSelectionFilteredOnly: true,
            headerCheckboxSelection: true,
        },
        {
            headerName: 'Tanggal',
            field: 'Tanggal',
            filter: true,
            width: 175,
            //valueFormatter: dateFormatter
        },
        {
            headerName: 'Member ID',
            field: 'MemberID',
            filter: true,
            width: 175,
        },
        {
            headerName: 'Name',
            field: 'Name',
            filter: true,
            width: 400,
        },
        {
            headerName: 'Bonus Poin',
            field: 'BonusPoint',
            filter: true,
            valueFormatter: numericFormatter,
            cellStyle: {
                "text-align": "right"
            }
        },
        {
            headerName: 'Bonus Sponsor',
            field: 'BonusSponsor',
            filter: true,
            valueFormatter: numericFormatter,
            cellStyle: {
                "text-align": "right"
            }
            //width: 150,
        },
        {
            headerName: 'Total Bonus',
            field: 'Total',
            filter: true,
            valueFormatter: numericFormatter,
            cellStyle: {
                "text-align": "right"
            }
        }
    ];

    /*** GRID OPTIONS ***/
    var gridOptions = {
        defaultColDef: {
            sortable: true
        },
        enableRtl: isRtl,
        columnDefs: columnDefs,
        rowSelection: "multiple",
        floatingFilter: true,
        filter: true,
        pagination: true,
        paginationPageSize: 20,
        pivotPanelShow: "always",
        colResizeDefault: "shift",
        //animateRows: true,
        resizable: true,
    };
    if (document.getElementById("myGrid")) {
        /*** DEFINED TABLE VARIABLE ***/
        var gridTable = document.getElementById("myGrid");

        /*** GET TABLE DATA FROM URL ***/
        agGrid
            .simpleHttpRequest({
                url: "/admin/unpaidBonus"
            })
            .then(function (data) {
                gridOptions.api.setRowData(data);
            });

        /*** FILTER TABLE ***/
        function updateSearchQuery(val) {
            gridOptions.api.setQuickFilter(val);
        }

        $(".ag-grid-filter").on("keyup", function () {
            updateSearchQuery($(this).val());
        });

        /*** CHANGE DATA PER PAGE ***/
        function changePageSize(value) {
            gridOptions.api.paginationSetPageSize(Number(value));
        }

        $(".sort-dropdown .dropdown-item").on("click", function () {
            var $this = $(this);
            changePageSize($this.text());
            $(".filter-btn").text("1 - " + $this.text() + " of 50");
        });

        /*** EXPORT AS CSV BTN ***/
        $(".ag-grid-export-btn").on("click", function (params) {
            gridOptions.api.exportDataAsCsv();
        });

        /*** ================================================ ***/
        $("#btn-pay").on("click", function (params) {
            params.preventDefault();

            var rows = gridOptions.api.getSelectedNodes();
            if (rows.length == 0) return;

            $.ajaxSetup({
                type: "POST",
                url: "/admin/payBonus",
                headers: addAuthHeader()
            });

            showSTJModal();
            let _data = [];
            /*for (var i = 0; i < rows.length; i++)
            {
                _data.push(rows[i].data);
                _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

                $.ajax({ data: _data })
                .done(function( result ) {
                });
            }*/

            let _rows = [];
            for (var i = 0; i < rows.length; i++)
            {
                _rows.push(rows[i].data.id);
            }

            _data.push({ 'name': 'rows', 'value': JSON.stringify(_rows) });
            _data.push({'name': '_token', 'value': $('meta[name="csrf-token"]').attr('content')});

            $.ajax({ data: _data })
            .done(function( result ) {
                hideSTJModal();
            });

            hideSTJModal();

        });
        /*** ================================================ ***/

        //  filter data function
        var filterData = function agSetColumnFilter(column, val) {
            var filter = gridOptions.api.getFilterInstance(column)
            var modelObj = null
            if (val !== "all") {
                modelObj = {
                    type: "equals",
                    filter: val
                }
            }
            filter.setModel(modelObj)
            gridOptions.api.onFilterChanged()
        }
        //  filter inside role
        $("#users-list-role").on("change", function () {
            var usersListRole = $("#users-list-role").val();
            filterData("role", usersListRole)
        });
        //  filter inside verified
        $("#users-list-verified").on("change", function () {
            var usersListVerified = $("#users-list-verified").val();
            filterData("is_verified", usersListVerified)
        });
        //  filter inside status
        $("#users-list-status").on("change", function () {
            var usersListStatus = $("#users-list-status").val();
            filterData("status", usersListStatus)
        });
        //  filter inside department
        $("#users-list-department").on("change", function () {
            var usersListDepartment = $("#users-list-department").val();
            filterData("department", usersListDepartment)
        });
        // filter reset
        $(".users-data-filter").click(function () {
            $('#users-list-role').prop('selectedIndex', 0);
            $('#users-list-role').change();
            $('#users-list-status').prop('selectedIndex', 0);
            $('#users-list-status').change();
            $('#users-list-verified').prop('selectedIndex', 0);
            $('#users-list-verified').change();
            $('#users-list-department').prop('selectedIndex', 0);
            $('#users-list-department').change();
        });

        /*** INIT TABLE ***/
        new agGrid.Grid(gridTable, gridOptions);
    }
    // users language select
    if ($("#country_id").length > 0) {
        $("#country_id").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: 'Pilih negara',
            allowClear: true
        });
    }
    // users music select
    if ($("#country_id").length > 0) {
        $("#province_id").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: 'Pilih propinsi',
            allowClear: true
        });
    }
    // users movies select
    if ($("#country_id").length > 0) {
        $("#city_id").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: 'Pilih kota',
            allowClear: true
        });
    }
    // users birthdate date
    if ($(".birthdate-picker").length > 0) {
        $('.birthdate-picker').pickadate({
            format: 'mmmm, d, yyyy'
        });
    }
    // Input, Select, Textarea validations except submit button validation initialization
    if ($(".users-edit").length > 0) {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }

    $('#btn-pass').click(function (e) {
        $('#hide_pass').show();
    })
});
