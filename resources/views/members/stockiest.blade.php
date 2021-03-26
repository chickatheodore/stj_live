@extends('layouts/contentLayoutMaster')

@section('title', 'List Stockiest')

@section('content')
    <section id="stocikest-layout">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-hover table-bordered" style="width: 100%;">
                                    <tr>
                                        <th style="width:30%">Member ID</th>
                                        <th style="width:40%">Nama</th>
                                        <th style="width:30%">No. Telp</th>
                                    </tr>
                                    @foreach($stockiests as $member)
                                        <tr>
                                            <td>{{ $member->code }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->phone }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                </div>
                <button type="button" id="test-api">Test</button>
            </div>
        </div>

    </section>
@endsection
@section('page-script')
    <!-- Page js files -->

    <script type="text/javascript">
        $('#test-api').click(function (e) {
            $.ajaxSetup({
                type: "GET",
                url: "/member/getMember",
                headers: addAuthHeader()
            });
            $.ajax({
                data: { 'id': 2}
            }).fail(function (f) {
                //alert('fail');
            })
            .done(function (d) {
                alert('done');
            });
        });
    </script>
@endsection
