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
            headerName: 'Username',
            field: 'username',
            filter: true,
            width: 175,
        },
        /*{
            headerName: 'Email',
            field: 'email',
            filter: true,
            width: 225,
        },*/
        {
            headerName: 'Name',
            field: 'name',
            filter: true,
            //width: 200,
        },
        {
            headerName: 'Sponsor',
            field: 'sponsor',
            filter: true,
            //width: 150,
        },
        {
            headerName: 'Upline',
            field: 'upLine',
            filter: true,
            //width: 150,
        },
        {
            headerName: 'Downline Kiri',
            field: 'leftDownLine',
            filter: true,
            /*width: 150,
            cellStyle: {
                "text-align": "center"
            }*/
        },
        {
            headerName: 'Downline Kanan',
            field: 'rightDownLine',
            filter: true,
            width: 125,
            /*cellStyle: {
                "text-align": "center"
            }*/
        },
        {
            headerName: 'TUPO',
            field: 'close_point_date',
            filter: true,
            width: 150,
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
        animateRows: true,
        resizable: true
    };
    if (document.getElementById("myGrid")) {
        /*** DEFINED TABLE VARIABLE ***/
        var gridTable = document.getElementById("myGrid");

        /*** GET TABLE DATA FROM URL ***/
        agGrid
            .simpleHttpRequest({
                url: "getStockiest"
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
    // Input, Select, Textarea validations except submit button validation initialization
    if ($(".users-edit").length > 0) {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }

    $('#btn-pass').click(function (e) {
        $('#hide_pass').show();
    })
});
