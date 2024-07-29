@extends('back.layouts.main')

@push('scripts')
    <script>
        function tokopay() {
            $.ajax({
                url: '{{ route("get_tokopay") }}',
                success: function(data) {
                    if(data.status == 1) {
                        $('#badge-tokopay-connect').removeClass('bg-danger');
                        $('#badge-tokopay-connect').addClass('bg-success');
                        $('#badge-tokopay-connect').text('Terkoneksi');
                        $('#tokopay-tersedia').text(data.data.saldo_tersedia);
                        $('#tokopay-tertahan').text(data.data.saldo_tertahan);
                        $('#badge-tokopay').removeClass('bg-danger').addClass('bg-primary').html('Tersedia - Rp. <span id="tokopay-tersedia">' + data.data.saldo_tersedia + '</span>');
                        $('#badge-tokopay2').removeClass('d-none').addClass('bg-warning').html('Tertahan - Rp. <span id="tokopay-tertahan">' + data.data.saldo_tertahan + '</span>');
                    } else {
                        $('#badge-tokopay-connect').text('Tidak Terkoneksi').removeClass('bg-success').addClass('bg-danger');
                        $('#badge-tokopay').removeClass('bg-primary').addClass('bg-danger').html(data.error_msg);
                        $('#badge-tokopay2').addClass('d-none');
                    }
                },
                error: function(error) {
                    $('#badge-tokopay-connect').text('Error').removeClass('bg-success bg-danger').addClass('bg-secondary');
                    $('#badge-tokopay').removeClass('bg-primary').addClass('bg-danger').html('[ Error ]');
                    $('#badge-tokopay2').addClass('d-none');
                }
            });
        }

        tokopay();

        $(document).ready(function() {
            $('#website-config-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: response.status ? 'success' : 'error',
                            title: response.status ? 'Success!' : 'Error!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                        if (errors) {
                            var errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                            errorMessage = 'Error:\n' + errorText;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#payment-gateway-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: response.status ? 'success' : 'error',
                            title: response.status ? 'Success!' : 'Error!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            tokopay();
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                        if (errors) {
                            var errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                            errorMessage = 'Error:\n' + errorText;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#kontak-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: response.status ? 'success' : 'error',
                            title: response.status ? 'Success!' : 'Error!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            tokopay();
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                        if (errors) {
                            var errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                            errorMessage = 'Error:\n' + errorText;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#profit-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: response.status ? 'success' : 'error',
                            title: response.status ? 'Success!' : 'Error!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            tokopay();
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                        if (errors) {
                            var errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                            errorMessage = 'Error:\n' + errorText;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });


    </script>
@endpush

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h5>Konfigurasi SEO Website</h5>
        </div>
        <div class="card-body">
            <form id="website-config-form" action="{{ route('update_website_conf') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="web_title">Website Title</label>
                    <input type="text" class="form-control" name="web_title" id="web_title" value="{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <label for="web_description">Deskripsi Website</label>
                    <textarea class="form-control" name="web_description" id="web_description">{{ optional(app('web_conf')->where('conf_key', 'web_description')->first())->conf_value }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="web_footer">Deskripsi Footer</label>
                    <textarea class="form-control" name="web_footer" id="web_footer">{{ optional(app('web_conf')->where('conf_key', 'web_footer')->first())->conf_value }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="web_author">Author Website</label>
                    <input type="text" class="form-control" name="web_author" id="web_author" value="{{ optional(app('web_conf')->where('conf_key', 'web_author')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <label for="web_keywords">Keywords</label>
                    <input type="text" class="form-control" name="web_keywords" id="web_keywords" value="{{ optional(app('web_conf')->where('conf_key', 'web_keywords')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <span>Preview Logo</span>
                            <div class="mb-3">
                                <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" alt="Logo" width="100" height="100">
                            </div>
                            <label for="web_logo">Logo Website</label><span class="text-sm text-danger"> *Rasio Gambar 1:1</span>
                            <input type="file" class="form-control" name="web_logo" id="web_logo">
                        </div>
                        <div class="col-md-6">
                            <span>Preview Favicon</span>
                            <div class="mb-3">
                                <img src="{{ optional(app('web_conf')->where('conf_key', 'web_icon')->first())->conf_value }}" alt="Icon" width="100" height="100">
                            </div>
                            <label for="web_icon">Icon Website</label><span class="text-sm text-danger"> *Rasio Gambar 1:1</span>
                            <input type="file" class="form-control" name="web_icon" id="web_icon">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary col-12">Submit</button>
            </form>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-header">
            <h5>Konfigurasi Payment Gateway</h5>
            <div class="p-0 m-0">
                <span id="badge-tokopay-connect" class="badge bg-danger me-1">Koneksi</span>
                <span id="badge-tokopay" class="badge bg-primary me-1">Tersedia - Rp. <span id="tokopay-tersedia">0</span></span>
                <span id="badge-tokopay2" class="badge bg-warning">Tertahan - Rp. <span id="tokopay-tertahan">0</span></span>
            </div>
        </div>
        <div class="card-body">
            <form id="payment-gateway-form" action="{{ route('update_payment_gateway') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tokopay_api">API KEY</label>
                    <input type="text" class="form-control" name="tokopay_api" id="tokopay_api">
                </div>
                <div class="mb-3">
                    <label for="tokopay_secret">SECRET KEY</label>
                    <input type="text" class="form-control" name="tokopay_secret" id="tokopay_secret">
                </div>
                <button type="submit" class="btn btn-primary col-12">Submit</button>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5>Konfigurasi Kontak</h5>
        </div>
        <div class="card-body">
            <form id="kontak-form" action="{{ route('update_kontak') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="web_location">Lokasi</label>
                    <input type="text" class="form-control" name="web_location" id="web_location" value="{{ optional(app('web_conf')->where('conf_key', 'web_location')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <label for="cs_phone">Nomor Ponsel CS</label>
                    <input type="number" class="form-control" name="cs_phone" id="cs_phone" value="{{ optional(app('web_conf')->where('conf_key', 'cs_phone')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <label for="cs_email">Email CS</label>
                    <input type="text" class="form-control" name="cs_email" id="cs_email" value="{{ optional(app('web_conf')->where('conf_key', 'cs_email')->first())->conf_value }}">
                </div>
                <button type="submit" class="btn btn-primary col-12">Submit</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Konfigurasi Profit</h5>
        </div>
        <div class="card-body">
            <form id="profit-form" action="{{ route('update_web_profit') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="take_fee">Profit Persen</label>
                    <input type="text" class="form-control" name="take_fee" id="take_fee" value="{{ optional(app('web_conf')->where('conf_key', 'take_fee')->first())->conf_value }}">
                    <div class="text-danger small">* Profit diambil dengan persen.</div>
                </div>                
                <button type="submit" class="btn btn-primary col-12">Submit</button>
            </form>
        </div>
    </div>
@endsection
