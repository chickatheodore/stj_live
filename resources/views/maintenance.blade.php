@extends('layouts/fullLayoutMaster')

@section('title', 'Maintenance')

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/coming-soon.css')) }}">
    <style type="text/css">
        #fancyClock{
            margin:40px auto;
            height:200px;
            border:1px solid #111111;
            width:600px;
            display: flex;
        }
        .clock{
            /* The .clock div. Created dynamically by jQuery */
            background-color:#252525;
            height:200px;
            width:200px;
            position:relative;
            overflow:hidden;
            float:left;
        }

        .clock .rotate{
            /* There are two .rotate divs - one for each half of the background */
            position:absolute;
            width:200px;
            height:200px;
            top:0;
            left:0;
        }

        .rotate.right{
            display:none;
            z-index:11;
        }

        .clock .bg, .clock .front{
            width:100px;
            height:200px;
            background-color:#252525;
            position:absolute;
            top:0;
        }

        .clock .display{
            /* Holds the number of seconds, minutes or hours respectfully */
            position:absolute;
            width:200px;
            font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
            z-index:20;
            color:#F5F5F5;
            font-size:60px;
            text-align:center;
            top:65px;
            left:0;

            /* CSS3 text shadow: */
            text-shadow:4px 4px 5px #333333;
        }

        /* The left part of the background: */

        .clock .bg.left{ left:0; }

        /* Individual styles for each color: */
        .orange .bg.left{ background:url(/images/clock/bg_orange.png) no-repeat left top; }
        .green .bg.left{ background:url(/images/clock/bg_green.png) no-repeat left top; }
        .blue .bg.left{	background:url(/images/clock/bg_blue.png) no-repeat left top; }

        /* The right part of the background: */
        .clock .bg.right{ left:100px; }

        .orange .bg.right{ background:url(/images/clock/bg_orange.png) no-repeat right top; }
        .green .bg.right{ background:url(/images/clock/bg_green.png) no-repeat right top; }
        .blue .bg.right{ background:url(/images/clock/bg_blue.png) no-repeat right top; }


        .clock .front.left{
            left:0;
            z-index:10;
        }
    </style>
@endsection
@section('content')
<!-- coming soon flat design -->
<section style="margin-top: -8rem;">
  <div class="row d-flex vh-100 align-items-center justify-content-center">
    <div class="col-xl-5 col-md-8 col-sm-10 col-12 px-md-0 px-2">
        <div class="card text-center w-100 mb-0">
            <div class="card-header justify-content-center pb-0">
                <div class="card-title">
                    <!-- <h2 class="mb-0">Mohon maaf, akses kami tutup dari jam 00:00 WITA sampai dengan jam 06:00 WITA.</h2> -->
                    <h2 class="mb-0">Mohon maaf, akses kami tutup sementara karena ada maintenance.</h2>
                    <hr>
                    <h4>{{ Carbon\Carbon::now()->format('d-M-Y H:m A') }}</h4>
                    <hr>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body pt-0">
                    <img src="{{ asset('images/pages/rocket.png') }}" class="img-responsive block width-150 mx-auto" width="150" alt="bg-img">
                    <hr>
                    <div id="fancyClock"></div>
                    <div id="clockFlat" class="card-text text-center getting-started pt-2 d-flex justify-content-center flex-wrap"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
<!--/ coming soon flat design -->
@endsection
@section('vendor-script')
        {{-- vendor js files --}}
        <script src="{{ asset(mix('vendors/js/coming-soon/jquery.countdown.min.js')) }}"></script>
@endsection

@section('page-script')
        {{-- Page js files --}}
        <script src="{{ Helper::asset(mix('js/scripts/maintenance.js')) }}"></script>
@endsection
