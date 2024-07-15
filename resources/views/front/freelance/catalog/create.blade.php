@extends('front.layouts.main')

@push('styles')
    <style>
        .owl-carousel .item {
            width: 400px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .owl-carousel .item img,
        .owl-carousel .item video {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var packageCounter = 1;

        $(document).on("click", ".package-add", function () {
            var signcontent =
                `<div class="row sign-cont">
                    <div class="col-md-6">
                        <div class="form-wrap">
                            <label class="col-form-label">Nama Paket</label>
                            <input type="text" name="packages[${packageCounter}][package_name]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-wrap">
                            <label class="col-form-label">Harga</label>
                            <input type="text" name="packages[${packageCounter}][price]" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-wrap">
                            <label class="col-form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" name="packages[${packageCounter}][package_description]" placeholder="Deskripsi paket anda"></textarea>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <a href="javascript:void(0);" class="btn btn-danger trash-sign text-white">Hapus</a>
                    </div>
                </div>`;
            
            $(".add-content").append(signcontent);
            packageCounter++;
            return false;
        });

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        video:true,
        center:true,
        autoplay:true,
        autoplayTimeout:1000,   
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
        }
    });
    
    $(document).ready(function() {
        var inputIndex = 0;

        function handleFileSelect(event) {
            $('#data_media_' + inputIndex).hide();

            inputIndex++;

            var newInput = $('<input type="file" name="path_image['+inputIndex+'][]" accept="image/*,video/*" id="data_media_' + inputIndex + '">');
            newInput.on('change', handleFileSelect);
            $('#data_media').after(newInput);

            var files = event.target.files;

            if (files && files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                            var mediaId = 'media-' + (inputIndex - 0);
                            var fileType = theFile.type.split('/')[0];
                            var uploadedMediaHTML = `
                                <div class="upload-wrap" id="${mediaId}">
                                    <div class="upload-image">
                                        <i class="feather-${fileType === 'image' ? 'image' : 'video'} me-1"></i>
                                        <h6>${theFile.name}</h6>
                                    </div>
                                    <a href="javascript:void(0);" class="del-action" data-media-id="${mediaId}">
                                        <i class="feather-trash-2"></i>
                                    </a>
                                </div>`;

                            $('#upload-wrap').append(uploadedMediaHTML);

                            var carouselMediaHTML = fileType === 'image' ?
                                `<div class="item"><img src="${e.target.result}" alt="${theFile.name}"></div>` :
                                `<div class="item"><video controls><source src="${e.target.result}" type="${theFile.type}"></video></div>`;
                            $('.owl-carousel').trigger('add.owl.carousel', [$(carouselMediaHTML)]).trigger('refresh.owl.carousel');
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            }
        }

        $('#data_media').on('change', handleFileSelect);

        $(document).on('click', '.del-action', function() {
            var mediaId = $(this).data('media-id');
        
            var $mediaWrap = $('#' + mediaId);
            var src = $mediaWrap.find('img').attr('src') || $mediaWrap.find('video source').attr('src');
            $mediaWrap.remove();

            var carouselItem = $('.owl-carousel').find(`[src="${src}"]`).closest('.item');
            $('.owl-carousel').trigger('remove.owl.carousel', carouselItem.index()).trigger('refresh.owl.carousel');

            var numericId = mediaId.split('-')[1];
            data_id = numericId - 1;
            console.log(data_id);

            if(data_id === 0){
                $(`#data_media`).val('');;
            } else {
                $(`#data_media_${data_id}`).remove();
            }
        });
    });
    </script>
@endpush

@section('content')
<div class="page-content">
    <div class="container">
        <form action="{{ route('create-catalog-freelance') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="property-info">
                        <h4>Freelance</h4>
                        <p>Tambahkan detail tentang katalog anda untuk meningkatkan kehadiran dan kualitas bisnis Anda.</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="add-property-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <label class="col-form-label">Judul Katalog *</label>
                                    <input type="text" name="title_name" class="form-control @error('title_name') is-invalid @enderror" value="{{ old('title_name') }}">
                                    @error('title_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <label class="col-form-label">Pilih Kategori</label>
                                    <select class="select form-control @error('category') is-invalid @enderror" name="category">
                                        <option disabled selected>-- Pilih Kategori --</option>
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <label class="col-form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="6" name="description" placeholder="Masukan deskripsi tentang katalog anda. *">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="property-info">
                        <h4>Paket</h4>
                        <p>Tambahkan paket yang anda tawarkan kepada para pelanggan.</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="add-property-wrap">
                        <div class="add-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Nama Paket</label>
                                        <input type="text" name="packages[0][package_name]" class="form-control @error('packages.0.package_name') is-invalid @enderror" value="{{ old('packages.0.package_name') }}">
                                        @error('packages.0.package_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-wrap">
                                        <label class="col-form-label">Harga</label>
                                        <input type="text" name="packages[0][price]" class="form-control @error('packages.0.price') is-invalid @enderror" value="{{ old('packages.0.price') }}">
                                        @error('packages.0.price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-wrap">
                                    <label class="col-form-label">Deskripsi</label>
                                    <textarea class="form-control @error('packages.0.package_description') is-invalid @enderror" rows="3" name="packages[0][package_description]" placeholder="Deskripsi paket anda">{{ old('packages.0.package_description') }}</textarea>
                                    @error('packages.0.package_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-secondary package-add"><i class="feather-plus-circle"></i>Tambah Paket</a>
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="property-info">
                        <h4>Upload</h4>
                        <p>Tambahkan gambar atau video untuk portofolio anda.</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="add-property-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Upload Portofolio</h6>
                                <h6 class="text-center">Preview akan ditampilkan disini</h6>
                                <div class="row mb-3">
                                    <div class="owl-carousel owl-theme owl-loaded owl-drag">
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="upload-media">
                                        <div class="drag-upload form-wrap">
                                            <input type="file" name="path_image[0][]" accept="image/*,video/*" id="data_media" class="form-control @error('path_image.0.0') is-invalid @enderror">
                                            <div class="img-upload">
                                                <p><i class="feather-upload-cloud"></i>Drag or Upload Image/Video</p>
                                            </div>
                                            @error('path_image.0.0')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="upload-wrap">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-item text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection