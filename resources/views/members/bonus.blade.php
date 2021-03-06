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
                        <!-- <div class="card">
                            <div class="card-body text-center">
                                Poin<br />
                                {{ number_format($member->point_bonus, 0) }}
                            </div>
                        </div> -->
                        <div class="card">
                            <div class="card-body text-center">
                                Sponsor<br />
                                {{ number_format($member->sponsor_bonus, 0) }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                Pasangan<br />
                                {{ number_format($member->pair_bonus, 0) }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                Total Bonus<br />
                                @php
                                //$total = floatval($member->point_bonus) + floatval($member->sponsor_bonus) + floatval($member->pair_bonus);
                                $total = floatval($member->sponsor_bonus) + floatval($member->pair_bonus);
                                @endphp
                                {{ number_format($total, 0) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                </div>
            </div>
        </div>

    </section>
@endsection
