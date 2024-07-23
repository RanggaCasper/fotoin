@extends('back.layouts.main')

@push('scripts')
 <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('get_payment_channel') }}',
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'name', name: 'name' },
                    { data: 'image', name: 'image' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });

            $('#form-update').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action = $(this).attr('action');
                var method = $(this).find('input[name="_method"]').val() || 'POST';

                $.ajax({
                    url: action,
                    type: method === 'PUT' ? 'POST' : method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-HTTP-Method-Override': method
                    },
                    success: function(response) {
                        Swal.fire('Sukses!', response.message, 'success');
                        $('#datatable').DataTable().ajax.reload();
                        $('#reset-button').click();
                        $('#update-modal').modal('hide');
                    },
                    error: function(error) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data payment channel.', 'error');
                    }
                });
            });

            $('#datatable').on('click', '.update', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route("get_payment_channel_id", ["id" => ":id"]) }}'.replace(':id', id),
                    type: 'GET',
                    success: function(data) {
                        $('#form-update').attr('action', '{{ route("update_payment_channel", ["id" => ":id"]) }}'.replace(':id', id));
                        $('#form-update').append('<input type="hidden" name="_method" value="PUT">');
                        $('#name').val(data.name);
                        $('#code').val(data.code);
                        $('#desc').val(data.desc);
                        $('#is_qris').prop('checked', data.is_qris);
                        $('#flat_fee').val(data.flat_fee);
                        $('#percent_fee').val(data.percent_fee);
                        $('#min_amount').val(data.min_amount);
                        $('#max_amount').val(data.max_amount);
                        $('#image-preview').attr('src', data.image).show();
                        $('#submit-button').text('Update');
                        $('#update-modal').modal('show');
                    },
                    error: function(error) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data payment channel.', 'error');
                    }
                });
            });

            $('#datatable').on('click', '.delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("delete_payment_channel", ["id" => ":id"]) }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    $('#datatable').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(error) {
                                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus payment channel.', 'error');
                            }
                        }); 
                    }
                });
            });

            $('#image').on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#reset-button').on('click', function() {
                $('#form-update').attr('action', '{{ route("create_payment_channel") }}');
                $('#form-update').find('input[name="_method"]').remove();
                $('#form-update')[0].reset();
                $('#image-preview').attr('src', '').hide();
                $('#submit-button').text('Tambah');
            });
        });
    </script>
@endpush

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5>Tambah Payment Channel</h5>
    </div>
    <div class="card-body">
        <form method="POST" id="form-update" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="code">Kode</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}" required>
                @error('code')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="desc">Deskripsi</label>
                <textarea name="desc" id="desc" class="form-control @error('desc') is-invalid @enderror" rows="3">{{ old('desc') }}</textarea>
                @error('desc')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="is_qris">QRIS</label>
                <input type="checkbox" name="is_qris" id="is_qris">
            </div>
            <div class="mb-3">
                <label class="form-label" for="flat_fee">Biaya Flat</label>
                <input type="number" class="form-control @error('flat_fee') is-invalid @enderror" name="flat_fee" id="flat_fee" value="{{ old('flat_fee') }}" required>
                @error('flat_fee')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="percent_fee">Biaya Persen</label>
                <input type="number" class="form-control @error('percent_fee') is-invalid @enderror" name="percent_fee" id="percent_fee" value="{{ old('percent_fee') }}" required>
                @error('percent_fee')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="min_amount">Jumlah Minimum</label>
                <input type="number" class="form-control @error('min_amount') is-invalid @enderror" name="min_amount" id="min_amount" value="{{ old('min_amount') }}" required>
                @error('min_amount')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="max_amount">Jumlah Maksimum</label>
                <input type="number" class="form-control @error('max_amount') is-invalid @enderror" name="max_amount" id="max_amount" value="{{ old('max_amount') }}" required>
                @error('max_amount')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="image">Gambar</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                @error('image')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <img id="image-preview" class="img-fluid mt-2" style="display: none;" />
            </div>
            <button type="submit" class="btn btn-primary" id="submit-button">Tambah</button>
            <button type="reset" class="btn btn-secondary" id="reset-button">Reset</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Payment Channel</h5>
    </div>
    <div class="card-body">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
