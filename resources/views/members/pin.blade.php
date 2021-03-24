@extends('layouts/contentLayoutMaster')

@section('title', 'Stock PIN')

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">

                <form class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Stock PIN Tersisa</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            <div class="form-group">
                                                <label for="pin-masuk">Total Stock Masuk</label>
                                                <input type="text" class="form-control" id="pin-masuk" placeholder="Total Stock Masuk" value="{{ number_format($pins->masuk, 0) }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="pin-keluar">Total Stock Keluar</label>
                                                <input type="text" class="form-control" id="pin-keluar" placeholder="Total Stock Keluar" value="{{ number_format($pins->keluar, 0) }}" readonly>
                                            </div>
                                            <hr />
                                            <div class="form-group">
                                                <label for="member-pin">Stock Tersisa</label>
                                                <input type="text" class="form-control" id="member-pin" placeholder="Stock Tersisa" value="{{ number_format($member->pin, 0) }}" readonly>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/members/pin.js')) }}"></script>
@endsection
