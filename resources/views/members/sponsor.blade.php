@extends('layouts/contentLayoutMaster')

@section('title', 'Pohon Sponsor')

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        @foreach($sponsors as $sponsor)
                            @php
                            if ($sponsor->upline_id === null)
                            {
                                continue;
                            }
                            @endphp
                        <div class="card">
                            <div class="card-body">
                                <table style="width: 100%; text-align: center">
                                    <tr>
                                        <td><h4>Data Member</h4></td>
                                        <td><h4>Data Upline</h4></td>
                                    </tr>
                                    <tr>
                                        <td><h4>{{ $sponsor->name }}</h4></td>
                                        @if ($sponsor->upline_id)
                                        <td><h4>{{ $sponsor->upLine->name }}</h4></td>
                                        @else
                                        -
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Member ID : {{ $sponsor->code }}</td>
                                        @if ($sponsor->upline_id !== null)
                                        <td>Member ID : {{ $sponsor->upLine->code }}</td>
                                        @else
                                        -
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                </div>
            </div>
        </div>

    </section>
@endsection

