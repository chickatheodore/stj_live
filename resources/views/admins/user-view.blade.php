@extends('layouts/contentLayoutMaster')

@section('title', 'Unapproved User')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
@endsection

@section('content')
    <!-- page users view start -->
    <section class="page-users-view">
        <div class="row">
            <!-- account start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Member</div>
                        <div class="row">
                            <div class="col-sm-4 col-12">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">Member ID</td>
                                        <td>{{ $member->code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Name</td>
                                        <td>{{ $member->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Email</td>
                                        <td>{{ $member->email }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 col-12 ">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">NIK</td>
                                        <td>{{ $member->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">KTP</td>
                                        <td>
                                            <a href="javascript: void(0);">
                                                <img id="gambar_ktp" src="{{ '/member/ktp/' . $member->code . '.jpg' }}" class="rounded mr-75" alt="gambar KTP" width="323px" height="204px">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Sponsor</td>
                                        <td>
                                            @php
                                                $sponsor = '';
                                                if ($member->sponsor_id !== null) {
                                                    $sponsor = $member->sponsor->name;
                                                }
                                            @endphp
                                            {{ $sponsor }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12">
                                <a href="#" class="btn btn-primary mr-1" id="btn-approve">
                                    <i class="feather icon-edit-1"></i> Approve
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- account end -->
        </div>
    </section>
    <!-- page users view end -->
@endsection

@section('page-script')
  {{-- Page js files --}}
    <script type="text/javascript">
    $('#btn-approve').click(function(e) {
        e.preventDefault();

        showSTJModal();
            $.ajaxSetup({
                type: "GET",
                headers: addAuthHeader()
            });

            _id = {{ $member->id }};
            _token = {{ $member->remember_token }};
            $.ajax({
                url: "/member/activate",
                data: { m: _id, t: _token }
            })
            .fail(function (e) {
                hideSTJModal();
                Swal.fire({
                    title: "Warning!",
                    text: "Terjadi kesalahan saat memproses permintaan.",
                    type: "warning",
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                    animation: false,
                    customClass: 'animated tada',
                });
            })
            .done(function( data ) {
                hideSTJModal();
                let result = JSON.parse(data);
                if (result.status === true)
                {
                    Swal.fire({
                        title: "Sukses",
                        text: "Member telah di approve.",
                        type: "info",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                        animation: false,
                        customClass: 'animated tada',
                    });
                }
            });

    });
    </script>
@endsection
