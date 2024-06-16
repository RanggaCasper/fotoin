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
                                    <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" width="100" alt="img">
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
                                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" autofocus></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="about">Tentang Saya</label>
                                        <textarea name="about" id="about" class="form-control @error('about') is-invalid @enderror" rows="6" placeholder="Deskripsikan tentang profesi anda">{{ old('about') }}</textarea>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="provinsi">Provinsi</label>
                                        <select class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" required>
                                            <option selected disabled>-- Pilih Salah Satu --</option>
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->code ?? '' }}" {{ old('provinsi') == ($item->code ?? '') ? 'selected' : '' }}>
                                                    {{ $item->name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-wrap">
                                                <label class="col-form-label" for="kota">Kabupaten / Kota</label>
                                                <select class="form-control @error('kota') is-invalid @enderror" name="kota" id="kota" required>
                                                    <option selected disabled>-- Pilih Salah Satu --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-warp">
                                                <label class="col-form-label" for="kecamatan">Kecamatan</label>
                                                <select class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan" required>
                                                    <option selected disabled>-- Pilih Salah Satu --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-warp">
                                                <label class="col-form-label" for="desa">Desa</label>
                                                <select class="form-control @error('desa') is-invalid @enderror" accpet="image" name="desa" id="desa" required>
                                                    <option selected disabled>-- Pilih Salah Satu --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-wrap">
                                                <label class="col-form-label" for="kode_pos">Kode Pos</label>
                                                <input type="number" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" class="form-control @error('kode_pos') is-invalid @enderror"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="alamat">Alamat Lengkap</label>
                                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="foto_ktp">Foto KTP</label>
                                        <span class="col-form-label text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_foto_ktp">(?)</span>
                                        <input type="file" name="foto_ktp" id="foto_ktp" value="{{ old('foto_ktp') }}" accept="image/*" class="form-control @error('foto_ktp') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="selfie_ktp">Foto Selfi</label>
                                        <span class="col-form-label text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_foto_selfie">(?)</span>
                                        <input type="file" name="selfie_ktp" id="selfie_ktp" value="{{ old('selfie_ktp') }}" accept="image/*" class="form-control @error('selfie_ktp') is-invalid @enderror"></input>
                                    </div>
                                    <div class="form-wrap">
                                        <label class="col-form-label" for="portofolio">Portofolio</label>
                                        <input type="file" name="portofolio" id="portofolio" value="{{ old('portofolio') }}" accept="image/*" class="form-control @error('portofolio') is-invalid @enderror"></input>
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
                        <img src="https://seller.fastwork.id/apply-seller/national-card/image-with-card-id.jpg" alt="Foto KTP" class="img-fluid">
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
                        <img src="https://seller.fastwork.id/apply-seller/national-card/image-card-id.jpg" alt="Foto KTP" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

    </div>

    @include('front.components.scripts')

    <script>
        $(document).ready(function () {
            var oldProvinsi = '{{ old('provinsi') }}';
            var oldKota = '{{ old('kota') }}';
            var oldKecamatan = '{{ old('kecamatan') }}';
            var oldDesa = '{{ old('desa') }}';

            if (oldProvinsi) {
                $('#provinsi').val(oldProvinsi).trigger('change');
                onChangeSelect('{{ route("wilayah-kota", ["id" => ":id"]) }}'.replace(':id', oldProvinsi), 'kota');
            }

            if (oldKota) {
                var provinsiId = oldProvinsi;
                if (provinsiId) {
                    onChangeSelect('{{ route("wilayah-kota", ["id" => ":id"]) }}'.replace(':id', provinsiId), 'kota', oldKota, function() {
                        if (oldKecamatan) {
                            onChangeSelect('{{ route("wilayah-kecamatan", ["id" => ":id"]) }}'.replace(':id', oldKota), 'kecamatan', oldKecamatan, function() {
                                if (oldDesa) {
                                    onChangeSelect('{{ route("wilayah-desa", ["id" => ":id"]) }}'.replace(':id', oldKecamatan), 'desa', oldDesa);
                                }
                            });
                        }
                    });
                }
            }

            $('#provinsi').on('change', function () {
                var id = $(this).val();
                resetDropdowns(['kota', 'kecamatan', 'desa']);
                if (id) {
                    onChangeSelect('{{ route("wilayah-kota", ["id" => ":id"]) }}'.replace(':id', id), 'kota');
                }
            });

            $('#kota').on('change', function () {
                var id = $(this).val();
                resetDropdowns(['kecamatan', 'desa']);
                if (id) {
                    onChangeSelect('{{ route("wilayah-kecamatan", ["id" => ":id"]) }}'.replace(':id', id), 'kecamatan');
                }
            });

            $('#kecamatan').on('change', function () {
                var id = $(this).val();
                resetDropdowns(['desa']);
                if (id) {
                    onChangeSelect('{{ route("wilayah-desa", ["id" => ":id"]) }}'.replace(':id', id), 'desa');
                }
            });
        });

        function onChangeSelect(url, targetId, oldValue, callback) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    var target = $('#' + targetId);
                    target.empty();
                    target.append('<option selected disabled>-- Pilih Salah Satu --</option>');
                    $.each(data, function (key, value) {
                        target.append('<option value="' + key + '">' + value + '</option>');
                    });
                    if (oldValue) {
                        target.val(oldValue).trigger('change');
                    }
                    if (callback) {
                        callback();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    $('#' + targetId).empty().append('<option selected disabled>-- Error --</option>');
                }
            });
        }

        function resetDropdowns(ids) {
            ids.forEach(function(id) {
                $('#' + id).empty().append('<option selected disabled>-- Pilih Salah Satu --</option>');
            });
        }

    </script>

</body>

</html>