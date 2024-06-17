@extends('back.layouts.main')

@push('scripts')
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('get-validasi-freelance') }}',
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'username', name: 'username' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'nik', name: 'nik' },
                    { data: 'aksi', name: 'aksi' },
                ]
            });
        });

        $('#datatable').on('click', '.detail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("get-freelance-id", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(data) {
                    $('#form-update').attr('action', '{{ route("update-validasi-freelance", ["id" => ":id"]) }}'.replace(':id', id));
                    $('#modal_username').text(data.user.username);
                    $('#modal_fullname').text(data.user.fullname);
                    $('#modal_nik').text(data.nik);
                    $('#modal_alamat').text(data.alamat);
                    $('#modal_provinsi').text(data.provinsi);
                    $('#modal_desa').text(data.desa);
                    $('#modal_kecamatan').text(data.kecamatan);
                    $('#modal_kota').text(data.kota);
                    $('#modal_kode_pos').text(data.kode_pos);
                    $('#modal_foto_ktp').attr('src', '{{ url('') }}/storage/'+data.foto_ktp);
                    $('#modal_foto_selfie').attr('src', '{{ url('') }}/storage/'+data.selfie_ktp);
                    $('#modal_portofolio').attr('src', '{{ url('') }}/storage/'+data.selfie_ktp);
                },
                error: function(error) {
                    
                }
            });
        });
        
    </script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Data Pengajuan Freelance</h5>
        </div>
        <div class="card-datatable">
            <table class="table datatable table-responsive" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detail-modal" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <form class="modal-content" id="form-update" method="POST">
            @csrf
            @method('put')
            <div class="modal-header">
              <h5 class="modal-title" id="backDropModalTitle">Detail Freelance</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-flush-spacing">
                    <tbody>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Username
                        </td>
                        <td>
                          <span id="modal_username">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Nama Lengkap
                        </td>
                        <td>
                          <span id="modal_fullname">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Nomor KTP (NIK)
                        </td>
                        <td>
                          <span id="modal_nik">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Provinsi
                        </td>
                        <td>
                          <span id="modal_provinsi">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Kabupaten / Kota
                        </td>
                        <td>
                          <span id="modal_kota">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Kecamatan
                        </td>
                        <td>
                          <span id="modal_kecamatan">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Desa
                        </td>
                        <td>
                          <span id="modal_desa">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Alamat Lengkap
                        </td>
                        <td>
                          <span id="modal_alamat">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Kode Pos
                        </td>
                        <td>
                          <span id="modal_kode_pos">?</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Foto KTP
                        </td>
                        <td>
                          <img id="modal_foto_ktp" class="img-fluid" alt="">
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Foto Selfie
                        </td>
                        <td>
                          <img id="modal_foto_selfie" class="img-fluid" alt="">
                        </td>
                      </tr>
                      <tr>
                        <td class="text-nowrap fw-semibold">
                          Portofolio Pendaftaran
                        </td>
                        <td>
                          <img id="modal_portofolio" class="img-fluid" alt="">
                        </td>
                      </tr>
                    </tbody>
                  </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                Close
              </button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">Terima</button>
            </div>
          </form>
        </div>
    </div>
    <!-- End Modal -->
@endsection