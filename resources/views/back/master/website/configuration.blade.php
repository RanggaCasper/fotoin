@extends('back.layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Konfigurasi SEO Website</h5>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="web_title">Website Title</label>
                    <input type="text" class="form-control" name="web_title" id="website_title" value="{{ optional(app('web_conf')->where('conf_key', 'web_title')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <label for="web_description">Deskripsi Website</label>
                    <textarea type="text" class="form-control" name="web_description" id="web_description">{{ optional(app('web_conf')->where('conf_key', 'web_description')->first())->conf_value }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="web_footer">Deskripsi Footer</label>
                    <textarea type="text" class="form-control" name="web_footer" id="web_footer">{{ optional(app('web_conf')->where('conf_key', 'web_footer')->first())->conf_value }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="web_author">Author Website</label>
                    <input type="text" class="form-control" name="web_author" id="web_author" value="{{ optional(app('web_conf')->where('conf_key', 'web_author')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <label for="web_keywoards">Keywoards</label>
                    <input type="text" class="form-control" name="web_keywoards" id="web_keywoards" value="{{ optional(app('web_conf')->where('conf_key', 'web_keywoards')->first())->conf_value }}">
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <span>Preview Logo</span>
                            <div class="mb-3">
                                <img src="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}" alt="Logo" width="100" height="100">
                            </div>
                            <label for="web_logo">Logo Website</label><span class="text-sm text-danger"> *Rasio Gambar 1:1</span>
                            <input type="text" class="form-control" name="web_logo" id="web_logo" value="{{ optional(app('web_conf')->where('conf_key', 'web_logo')->first())->conf_value }}">
                        </div>
                        <div class="col-md-6">
                            <span>Preview Favicon</span>
                            <div class="mb-3">
                                <img src="{{ optional(app('web_conf')->where('conf_key', 'web_icon')->first())->conf_value }}" alt="Icon" width="100" height="100">
                            </div>
                            <label for="web_icon">Icon Website</label><span class="text-sm text-danger"> *Rasio Gambar 1:1</span>
                            <input type="text" class="form-control" name="web_icon" id="web_icon" value="{{ optional(app('web_conf')->where('conf_key', 'web_icon')->first())->conf_value }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary col-12">Submit</button>
            </form>
        </div>
    </div>

@endsection