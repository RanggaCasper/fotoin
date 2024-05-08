<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Fotoin - Freelance Register</title>

    @include('front.components.styles')
</head>

<body>

    <div class="main-wrapper">

        <div class="row gx-0">

            <div class="col-lg-6">
                <div class="authentication-wrapper">
                    <div class="authentication-content">
                        <div class="login-carousel owl-carousel">
                            <div class="login-slider">
                                <img src="{{ asset('asset/img/login-card.png') }}" class="img-fluid" alt="img">
                                <h2>Looking to Buy/Sell a service?</h2>
                                <p>Browse Listing & More 900 Services </p>
                            </div>
                            <div class="login-slider">
                                <img src="{{ asset('asset/img/login-card.png') }}" class="img-fluid" alt="img">
                                <h2>Looking to Buy/Sell a service?</h2>
                                <p>Browse Listing & More 900 Services </p>
                            </div>
                        </div>
                    </div>
                    <div class="login-bg">
                        <img src="{{ asset('asset/img/bg/shape-01.png') }}" alt="img" class="shape-01">
                        <img src="{{ asset('asset/img/bg/shape-02.png') }}" alt="img" class="shape-02">
                        <img src="{{ asset('asset/img/bg/shape-03.png') }}" alt="img" class="shape-03">
                        <img src="{{ asset('asset/img/bg/shape-04.png') }}" alt="img" class="shape-04">
                        <img src="{{ asset('asset/img/bg/shape-05.png') }}" alt="img" class="shape-05">
                        <img src="{{ asset('asset/img/bg/shape-06.png') }}" alt="img" class="shape-06">
                        <img src="{{ asset('asset/img/bg/shape-07.png') }}" alt="img" class="shape-07">
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="login-wrapper">
                    <div class="login-content">
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="login-userset">
                                <div class="login-logo">
                                    <img src="{{ asset('asset/img/logo.svg') }}" alt="img">
                                </div>
                                <div class="login-card">
                                    <div class="login-heading mb-3">
                                        <h3>Hi, {{ auth()->user()->username }}!</h3>
                                        <p>Silahkan isi semua kolom dibawah ini.</p>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            <ul class="ms-3" style="list-style-type: disc;">
                                                @foreach($errors->all() as $error)
                                                    <li class="small">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger small">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="nik">Nomor KTP (NIK)</label>
                                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="about">Tentang Saya</label>
                                        <textarea name="about" id="about" class="form-control @error('about') is-invalid @enderror" rows="6" placeholder="Deskripsikan tentang profesi anda">{{ old('about') }}</textarea>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="alamat">Alamat Lengkap</label>
                                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror"></input>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-wrap">
                                                <label class="col-form-label" for="kelurahan">Kelurahan</label>
                                                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}" class="form-control @error('kelurahan') is-invalid @enderror"></input>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-wrap">
                                                <label class="col-form-label" for="kecamatan">Kecamatan</label>
                                                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}" class="form-control @error('kecamatan') is-invalid @enderror"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-wrap">
                                                <label class="col-form-label" for="kode_pos">Kode Pos</label>
                                                <input type="number" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" class="form-control @error('kode_pos') is-invalid @enderror"></input>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-wrap">
                                                <label class="col-form-label" for="kota">Kota</label>
                                                <input type="text" name="kota" id="kota" value="{{ old('kota') }}" class="form-control @error('kota') is-invalid @enderror"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="foto_ktp">Foto KTP</label>
                                        <span class="col-form-label text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_foto_ktp">(?)</span>
                                        <input type="file" name="foto_ktp" id="foto_ktp" value="{{ old('foto_ktp') }}" class="form-control @error('foto_ktp') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="selfie_ktp">Foto Selfi</label>
                                        <span class="col-form-label text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_foto_selfie">(?)</span>
                                        <input type="file" name="selfie_ktp" id="selfie_ktp" value="{{ old('selfie_ktp') }}" class="form-control @error('selfie_ktp') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="no_rekening">No Rekening</label>
                                        <input type="number" name="no_rekening" id="no_rekening" value="{{ old('no_rekening') }}" class="form-control @error('no_rekening') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="jenis_rekening">Jenis Rekening</label>
                                        <input type="text" name="jenis_rekening" id="jenis_rekening" value="{{ old('jenis_rekening') }}" class="form-control @error('jenis_rekening') is-invalid @enderror"></input>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Daftar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal new-modal fade" id="modal_foto_ktp" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contoh Foto KTP</h5>
                        <button type="button" class="close-btn" data-bs-dismiss="modal"><span>×</span></button>
                    </div>
                    <div class="modal-body service-modal">
                        <img class="img-fluid" src="https://seller.fastwork.id/apply-seller/national-card/image-card-id.jpg" alt="Foto KTP">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal new-modal fade" id="modal_foto_selfie" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contoh Foto Selfie</h5>
                        <button type="button" class="close-btn" data-bs-dismiss="modal"><span>×</span></button>
                    </div>
                    <div class="modal-body service-modal">
                        <img class="img-fluid" src="https://seller.fastwork.id/apply-seller/national-card/image-with-card-th.jpg" alt="Foto Selfie">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

    </div>

    @include('front.components.scripts')

</body>

</html>