@extends('layouts/contentLayoutMaster')

@section('title', 'Register Page')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
@endsection

@section('content')
    <section id="register-layout">
        <div class="row">
            <div class="col-md-12">
                <form class="form form-vertical" method="POST" action="{{ route('member.registration') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Registrasi Member</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Isi form di bawah ini.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">
                                            <div class="form-group">
                                                <label for="name">Username <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Sesuai KTP" value="{{ old('name') }}" required autofocus>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="nik">Nomor KTP <span class="small d-lg-block text-danger span_nik">*) Wajib diisi</span></label>
                                                <input type="number" id="nik" name="nik" class="form-control" placeholder="Nomor KTP" required maxlength="16">
                                            </div>

                                            <hr>
                                            <div class="media">
                                                <a href="javascript: void(0);">
                                                    @php
                                                        $path = '/member/ktp/no_image_available.jpg';
                                                    @endphp
                                                    <img id="gambar_ktp" src="{{ $path }}" class="rounded mr-75" alt="gambar KTP" height="204" width="323">
                                                </a>
                                                <div class="media-body mt-75">
                                                    <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                        <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                                                               for="image_file">Upload gambar KTP</label>
                                                        <input type="file" id="image_file" name="image_file" hidden required>
                                                        <button class="btn btn-sm btn-outline-warning ml-50">Reset</button>
                                                    </div>
                                                    <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max size of 800kB</small></p>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="form-group">
                                                <label for="address">Alamat <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                <input type="text" id="address" name="address" class="form-control" placeholder="Alamat" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="city_id">Kota</label>
                                                <select class="form-control city_id" id="city_id" name="city_id">
                                                    <option value=""></option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="province_id">Propinsi</label>
                                                <select class="form-control province_id" id="province_id" name="province_id">
                                                    <option value=""></option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="postal_code">Kode POS</label>
                                                <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Kode POS">
                                            </div>
                                            <div class="form-group">
                                                <label for="country_id">Negara</label>
                                                <select class="form-control country_id" id="country_id" name="country_id">
                                                    <option value=""></option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon<span class="small d-lg-block text-danger">*) Wajib diisi (1 nomor saja)</span></label>
                                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Rincian Bank</h4>
                                            </div>
                                        </div>
                                        <p class="px-2"><span class="small d-lg-block text-danger">*) Wajib diisi semua</span></p>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <div class="form-group">
                                                    <label for="bank">Bank</label>
                                                    <input id="bank" type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" placeholder="Bank" value="{{ old('bank') }}" required autocomplete="bank" autofocus>
                                                    @error('bank')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="account_number">Nomor Rekening</label>
                                                    <input id="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" placeholder="Nomor Rekening" value="{{ old('account_number') }}" required>
                                                    @error('account_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="account_name">Nama Nasabah</label>
                                                    <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" placeholder="Nama Nasabah" value="{{ old('account_name') }}" required>
                                                    @error('account_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Member ID</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <div class="form-group">
                                                    <label for="code">Member ID</label>
                                                    <input id="code" type="text" class="form-control" name="code" placeholder="Member ID" value="{{ old('code') }}" autofocus readonly>
                                                </div>
                                                <div class="form-group hidden">
                                                    <label for="username">Username</label>
                                                    <input id="username" type="text" class="form-control" name="username" placeholder="User Name" value="{{ old('username') }}" autofocus readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password <span class="small d-lg-block text-danger">*) Wajib diisi</span></label>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password-confirm">Confirm Password</label>
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12 d-flex justify-content-center">
                                <button type="submit" id="btn-register" class="btn btn-primary float-right btn-inline mb-50" disabled>Register</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="modal fade" id="crop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop gambar KTP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img id="show-image" src="https://avatars0.githubusercontent.com/u/3456749">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
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
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/members/register.js')).'?v='.date('Ymdhis') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

    <script type="text/javascript">
        let ktp_path = "{{ '/member/ktp/empty.jpg' }}";

        var cropper;
        var $modal = $('#crop-modal');
        var image = document.getElementById('show-image');

        image.addEventListener('ready', function () {
            cropper.moveTo(0,0);
            cropper.setCropBoxData({left:0, top:0, width:323, height:204});
        });

        $('#nik').keyup(function (e) {
            $('#nik').trigger('change');
        });

        $('#nik').change(function (e) {
            let _nik = $(this).val();
            if (_nik.length !== 16) {
                $('#btn-register').prop('disabled', true);
                if (_nik.length < 16 && _nik.length > 0)
                {
                    $('.span_nik').html('Kurang ' + (16 - _nik.length) + ' angka lagi.');
                } else if (_nik.length === 0)
                    $('.span_nik').html('*) Wajib diisi');
            } else {
                $('.span_nik').html('');
                checkNIK(_nik);
            }
        });

        function checkNIK(_nik)
        {
            $('#modal-backdrop').modal('show');
            $.ajaxSetup({
                type: "GET",
                headers: addAuthHeader()
            });
            $.ajax({
                url: "/member/validateKTP/" + _nik,
            })
            .fail(function (e) {
                $('#modal-backdrop').modal('hide');
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
                $('#modal-backdrop').modal('hide');
                let result = JSON.parse(data);
                if (result.status === false)
                {
                    Swal.fire({
                        title: "Warning!",
                        text: "NIK tidak dapat digunakan, sudah terpakai sebanyak 3 kali.",
                        type: "warning",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                        animation: false,
                        customClass: 'animated tada',
                    });
                    $('#nik').val(_nik.substr(0, _nik.length - 1));
                } else
                    $('#btn-register').prop('disabled', false);
            });
        }

        $("#image_file").on("change", function(e) {
            //var image = document.getElementById('gambar_ktp');
            //image.src = URL.createObjectURL(e.target.files[0]);

            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                //aspectRatio: 1,
                //viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 323,
                height: 204,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    $modal.modal('hide');
                    var base64data = reader.result;

                    $('#gambar_ktp')[0].src = base64data;
                    /*$.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "image-cropper/upload",
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                        success: function(data){
                            $modal.modal('hide');
                            alert("success upload image");
                        }
                    });*/
                }
            });
        });
    </script>
@endsection
