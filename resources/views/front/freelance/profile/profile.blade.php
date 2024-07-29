@extends('front.layouts.panel')

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profileImagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="main-title">
        <h3>Profile</h3>
    </div>
</div>
<div class="settings-card">
    <form action="{{ route('update_profile_user') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="settings-card-body">
            <div class="img-upload-head">
                <div class="profile-img">
                    <img id="profileImagePreview" src="{{ auth()->user()->profile_image }}" alt="Profile Image">
                </div>
                <div class="img-formate">
                    <p>Max file size is 5MB, Minimum dimension: 150x150 And Suitable files are
                        .jpg &amp; .png</p>
                    <div class="upload-remove-btns">
                        <div class="drag-upload form-wrap">
                            <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)">
                            <div class="img-upload">
                                <p>Upload Image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Field yang di-disable tidak akan diupdate -->
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Username</label>
                        <input type="text"  value="{{ auth()->user()->username }}" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Nama</label>
                        <input type="text"  value="{{ auth()->user()->fullname }}" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Nomor Ponsel</label>
                        <input type="text" value="{{ auth()->user()->no_telp }}" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-wrap">
                        <label>Jenis kelamin</label>
                        <input type="text" value="{{ auth()->user()->gender }}" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-wrap">
                        <label>Waktu Gabung</label>
                        <input type="text" value="{{ auth()->user()->created_at }}" class="form-control" disabled>
                    </div>
                </div>
                <!-- Field yang diupdate -->
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Password Sekarang</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-wrap">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="settings-card-footer">
            <div class="btn-item">
                <button type="reset" class="btn btn-secondary">Cancel</button>
                <button class="btn btn-primary" type="submit">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endsection
