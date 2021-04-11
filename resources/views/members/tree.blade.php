@extends('layouts/contentLayoutMaster')

@section('title', 'Pohon Member')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/jquery.orgchart.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/toastr.css')) }}">
    <style>
        .orgchart .node .title { width: 200px; }
        .orgchart .node .content { height: 104px; }
        .orgchart {
            /*background-image: none;*/ background-color:#f8f8f8;
            background-image: linear-gradient(
                90deg
                , rgba(102,102,153,.10) 10%, rgba(0,0,0,0) 10%),linear-gradient(rgba(102,102,153,.10) 10%,rgba(0,0,0,0) 10%);
        }

        .orgchart .exist .title { background-color: #006699; }
        .orgchart .exist .content { border-color: #006699; }
        .orgchart .gold .title { background-color: #FFA500; }
        .orgchart .gold .content { border-color: #FFA500; }
        .orgchart .empty .content { background-color: #FFC0CB; }

        :root {
            --main-color: #466289;
        }

        .orgchart .node .content .memberid {
            display: none;
        }

        .orgchart .node .content .membername {
            display: none;
        }

        .orgchart .node .content .membericon {
            display: none;
        }

        .orgchart .node .content .menu {
            position: absolute;
            right: -40px;
            top: 0px;
            width: 50px;
            display: none;
        }

        .orgchart .node .content .menu span {
            padding-top: 5px;
            padding-bottom: 5px;
            display: block;
            font-size: 18px;
            cursor: pointer;
        }

        .orgchart .node .content .menu span.info {
            display: none;
        }

        .orgchart .node:hover .content .menu {
            display: block;
        }

        .orgchart .lines .leftLine {
            border-left: 1px solid var(--main-color);
        }

        .orgchart .lines .rightLine {
            border-right: 1px solid var(--main-color);
        }

        .orgchart .lines .topLine {
            border-top: 1px solid var(--main-color);
        }

        .orgchart .lines .downLine {
            background-color: var(--main-color);
        }

        .orgchart .node.no-member .title {
            background: #d8d9da;
        }

        #chart-container:not(.minimize) .orgchart .node.no-member .content {
            border: 1px solid #d8d9da;
            color: #e0e0e0;
            min-width: 150px;
            height: 78px;
            display: -webkit-box !important;
            display: -ms-flexbox !important;
            display: flex !important;
            -webkit-box-align: center !important;
            -ms-flex-align: center !important;
            align-items: center !important;
            -webkit-box-pack: center !important;
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        #chart-container:not(.minimize) .orgchart .node.no-member .content .memberid {
            display: none;
        }

        #chart-container:not(.minimize) .orgchart .node.no-member .content .membername {
            display: none;
        }

        #chart-container:not(.minimize) .orgchart .node.no-member .content .membericon {
            display: none;
        }

        .orgchart .node:not(.lastchild) .content .menu .linkdownline {
            display: none;
        }

        /* Minimize version */
        .minimize .orgchart .node .title .symbol {
            display: none;
        }

        .minimize .orgchart .node.no-member .title,
        .minimize .orgchart .node .title {
            background: transparent;
            color: var(--main-color);
            border-bottom: none;
            display: none;
        }

        .minimize .orgchart .node.no-member .content,
        .minimize .orgchart .node .content {
            min-width: 100px;
            min-height: 50px;
            border-radius: 3px;
            text-align: center;
            display: block;
            border: none;
            cursor: pointer;
        }

        .minimize .orgchart .node.no-member .content div,
        .minimize .orgchart .node .content div {
            display: none;
        }

        .minimize .orgchart .node.no-member .content div.memberid,
        .minimize .orgchart .node .content div.memberid {
            display: block;
            width: unset;
            height: unset;
            font-size: 10px;
        }

        .minimize .orgchart .node.no-member .content div.membername,
        .minimize .orgchart .node .content div.membername {
            display: block;
            width: unset;
            height: unset;
            font-size: 12px;
            /*BARU*/
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
            /*white-space: break-spaces;*/
        }

        .minimize .orgchart .node.no-member .content div.membericon,
        .minimize .orgchart .node .content div.membericon {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--main-color);
            text-align: center;
            font-size: 24px;
            color: var(--main-color);
        }

        .minimize .orgchart .node.no-member .content .menu,
        .minimize .orgchart .node .content .menu {
            text-align: center;
            right: unset;
            top: unset;
            left: 0;
            bottom: -30px;
            background: white;
            width: 100%;
            padding-top: 10px;
        }

        .minimize .orgchart .node.no-member .content .menu span,
        .minimize .orgchart .node .content .menu span {
            display: inline-block;
            padding: 0px;
            padding-left: 8px;
            padding-right: 8px;
        }

        .minimize .orgchart .node.no-member .content .menu span:first-child,
        .minimize .orgchart .node .content .menu span:first-child {
            margin-bottom: 0;
        }

        .minimize .orgchart .node.no-member .content {
            color: #c1c3c7;
        }

        .minimize .orgchart .node.no-member .content div.membericon {
            color: #c1c3c7;
            border: 2px solid #c1c3c7;
        }

        .minimize .orgchart .lines .downLine {
            margin-top: -10px;
            height: 50px;
        }

        .minimize .orgchart:hover .node {
            background: none;
        }
        /*# sourceMappingURL=PohonPenempatan.css.map */

        /*.orgchart .node .verticalEdge, .orgchart .node .horizontalEdge { display: none; }*/

    </style>
@endsection

@php
//$read_only = isset($saved) || count($newMembers) < 1;
@endphp

@section('content')
    <section id="tree-layout">
        <div class="row">
            <div class="col-md-12">

                <div class="form-body">
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="card text-center">
                                <div class="card-header pt-50 pb-1"style="display: block">
                                    <div class="card-title">
                                        <h4 class="mb-0">Pohon Member</h4>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Tampilan" style="color: #ffffff">
                                        <button type="button" class="btn btn-sm border-primary tampil-ringkas btn-primary">Tampil ringkas</button>
                                        <button type="button" class="btn btn-sm border-primary tampil-detail">Tampil detail</button>
                                        <button type="button" class="btn btn-sm border-primary btn_export">Export</button>
                                    </div>
                                    <div class="mt-3">
                                        <div class="text-center font-weight-bold">Tipe Level Member :</div>
                                        <div class="text-center">
                                            <span class="mr-2"><i class="fa fa-user" style="font-size: 24px; color: #87CEEB"></i> BRONZE</span>
                                            <span class="mr-2"><i class="fa fa-user" style="font-size: 24px; color: #FFA500"></i> GOLD</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="px-2"></p>
                                <div class="card-content">
                                    <div id="chart-container" class="minimize"></div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-sm border-primary btn_reset">Reset</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="modal text-left show" id="modal-member" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary white">
                        <h5 class="modal-title" id="myModalLabel160">Data Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>Nama</h4></div>
                            <div class="col-md-6 modal_name"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>ID</h4></div>
                            <div class="col-md-6 modal_code"></div>
                       </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>PIN</h4></div>
                            <div class="col-md-6 modal_pin"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>P/S</h4></div>
                            <div class="col-md-6 modal_bv"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>TUPO</h4></div>
                            <div class="col-md-6 modal_cpd"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2"><h4>Point</h4></div>
                            <div class="col-md-6 modal_point"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/jquery.orgchart.min.js')).'?v='.date('Ymdhis') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/js/jquery.orgchart.js"></script> -->
    <script src="https://dabeng.github.io/OrgChart/js/html2canvas.min.js"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ Helper::asset(mix('js/scripts/members/tree.js')) }}"></script>
    <script type="text/javascript">
        let _mId = {{ auth()->id() }};
        let _orChart = null;

        $(document).ready(function () {
            initTree(_mId);
        });

        function cobaSaja(e, f) {
            let _a = '';
            //e.target
            resetNodeClick();

            /*$('div.node').each(function (a) {
                let _me = $(this);

                var childrenState = _orChart.getNodeState($(this), 'children');

                _me.unbind('click', 'nodeClickHandler');
                _me.on('click', onNodeClicked.bind(this));

                _me.unbind('mouseenter', 'nodeEnterLeaveHandler');
                _me.unbind('mouseleave', 'nodeEnterLeaveHandler');
            });*/
        }

    </script>
@endsection
