@extends('layouts/contentLayoutMaster')

@section('title', 'Member Dashboard')

@section('content')
    {{-- Dashboard Analytics Start --}}
    <section id="member-dashboard">
        <div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Upline :</h4><br />
                        @if ($member->upline_id)
                        {{ $member->upLine->name }}
                        @else
                        -
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Nama Member :</h4><br />
                        <b>{{ $member->name }}</b>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Member ID :</h4><br />
                        {{ $member->code }}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Tgl berakhir Tutup Poin</h4><br />
                        {{ Carbon\Carbon::parse($member->close_point_date)->format('d-M-Y') }}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Sisa hari masa berlaku Tutup Poin</h4><br />
                        @php
                            $dt = Carbon\Carbon::now();
                            $date = Carbon\Carbon::parse($member->close_point_date);
                        @endphp
                        {{ $date->diffInDays() }} Hari
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Poin</h4><br />
                        {{ number_format($member->left_point, 0) }} | {{ number_format($member->right_point, 0) }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </section>
    <!-- Dashboard Analytics end -->
@endsection
