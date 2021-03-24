@extends('layouts/contentLayoutMaster')

@section('title', 'Bonus')

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <div class="row"><div class="col-md-12 text-center"><h4>Bonus</h4></div></div>
                <hr />
                <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                Bergabung Sejak<br />
                                {{ Carbon\Carbon::parse($member->activation_date)->format('d-M-Y') }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                Lama Bergabung<br />
                                @php
                                $dt = Carbon\Carbon::now();
                                $date = Carbon\Carbon::parse($member->activation_date);
                                @endphp
                                {{ $dt->diffInMonths($date) }} Bulan ( {{ $date->diffInDays() }} Hari )
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                Pasangan Poin<br />
                                0
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                Sponsor<br />
                                0
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                Total Bonus<br />
                                0
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                </div>
            </div>
        </div>

    </section>
@endsection
