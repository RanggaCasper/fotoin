<div class="breadcrumb-bar breadcrumb-bar-info">
    <div class="breadcrumb-img">
        <div class="breadcrumb-left">
            <img src="{{ asset('asset/img/bg/banner-bg-03.png') }}" alt="img">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="banner-form">
                <form id="search-form">
                    <div class="banner-search-list">
                        <div class="input-block border-0">
                            <label for="search">Cari</label>
                            <input type="text" id="search" name="search" value="{{ $search }}"  class="form-control" placeholder="Butuh seorang fotografer">
                        </div>
                    </div>
                    <div class="input-block-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-magnifying-glass"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>