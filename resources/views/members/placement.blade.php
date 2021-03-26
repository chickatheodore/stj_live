@extends('layouts/contentLayoutMaster')

@section('title', 'Penempatan')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/toastr.css')) }}">
@endsection

@php
$read_only = isset($saved) || count($newMembers) < 1;
@endphp

@section('content')
    <style>
        .custom-radio {
            width: 100px;
            display: inline-block;
            margin: 5px;
        }
        .custom-radio label {
            display: block;
            text-align: center;
            width: 100px;
        }
        .custom-radio input {
            width: 20px;
            display: block;
            margin: 0px auto;
        }
    </style>
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" method="POST" action="{{ route('member.placement') }}">
                    @csrf

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">&nbsp;</div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Penempatan Member</h4>
                                        </div>
                                    </div>
                                    <p class="px-2"></p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">

                                            <div class="form-group">
                                                <label for="member_id">Member Baru</label>
                                                <select class="form-control sponsor_id" id="member_id" name="member_id" {{ $read_only ? 'disabled' : '' }}>
                                                    <option value=""></option>
                                                    @foreach($newMembers as $currMember)
                                                        @if(isset($saved))
                                                            @if($member->id == $currMember->id)
                                                    <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                            @endif
                                                        @else
                                                    <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <hr />

                                            <div class="form-group">
                                                <label for="sponsor_id">Sponsor</label>
                                                <select class="form-control sponsor_id" id="sponsor_id" name="sponsor_id" {{ $read_only ? 'disabled' : '' }}>
                                                    <option value=""></option>
                                                    @foreach($allMembers as $currMember)
                                                        @if(isset($saved))
                                                            @if($member->sponsor_id == $currMember->id)
                                                    <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                            @endif
                                                        @else
                                                    <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="upline_id">Upline</label>
                                                <select class="form-control upline_id" id="upline_id" name="upline_id" {{ $read_only ? 'disabled' : '' }}>
                                                    <option value=""></option>
                                                    @foreach($allMembers as $currMember)
                                                        @if(isset($saved))
                                                            @if($member->upline_id == $currMember->id)
                                                    <option value="{{ $currMember->id }}" selected>{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                            @endif
                                                        @else
                                                    <option value="{{ $currMember->id }}">{{ $currMember->code }} - {{ $currMember->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-label-group pohon">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-inline-block">
                                                        <fieldset>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" name="pohonRadio" id="pohonKiri" value="left" disabled>
                                                                <label class="custom-control-label" for="pohonKiri" id="labelKiri">
                                                                    @if(isset($saved))
                                                                        @if($member->upLine)
                                                                            @if($member->upLine->leftDownLine != null)
                                                                    {{ $member->upLine->leftDownLine->code }}<br />{{ $member->upLine->leftDownLine->name }}
                                                                            @else
                                                                    A. Tersedia
                                                                            @endif
                                                                        @else
                                                                    A. Tersedia
                                                                        @endif
                                                                    @else
                                                                    A. Tersedia
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                    <li class="d-inline-block" style="min-width:20px;">&nbsp;</li>
                                                    <li class="d-inline-block">
                                                        <fieldset>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" name="pohonRadio" id="pohonKanan" value="right" disabled>
                                                                <label class="custom-control-label" for="pohonKanan" id="labelKanan">
                                                                    @if(isset($saved))
                                                                        @if($member->upLine)
                                                                            @if($member->upLine->rightDownLine != null)
                                                                    {{ $member->upLine->rightDownLine->code }}<br />{{ $member->upLine->rightDownLine->name }}
                                                                            @else
                                                                    B. Tersedia
                                                                            @endif
                                                                        @else
                                                                    B. Tersedia
                                                                        @endif
                                                                    @else
                                                                    B. Tersedia
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="form-group">
                                                <label for="level_id">Upgrade level member</label>
                                                <select class="form-control level_id" id="level_id" name="level_id" disabled>
                                                    <option value=""></option>
                                                    @foreach($levels as $level)
                                                        @if($member->level_id == $level->id && $read_only)
                                                            <option value="{{ $level->id }}" selected>{{ $level->name }}</option>
                                                        @else
                                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="level-hide">Jumlah PIN : 0</div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <button type="submit" id="btn-save" class="btn btn-primary float-right btn-inline mb-50" disabled>Save changes</button>
                                </div>
                            </div>
                            <div class="col-md-3">&nbsp;</div>

                        </div>
                    </div>

                </form>
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
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/members/placement.js')).'?v='.date('Ymdhis') }}"></script>
@endsection
