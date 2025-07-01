@extends('layouts.user')
@section('content')
<section class="py-3">
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                    <h2 class="section-title">Kategori</h2>
                    <div class="d-flex align-items-center">
                        <a href="#" class="btn-link text-decoration-none">Lihat Semua Kategori →</a>
                        <div class="swiper-buttons">
                            <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                            <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="category-carousel swiper">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $item)
                        <a href="#" class="nav-link category-item swiper-slide">
                            <img src="{{ asset('user/images/icon-bread-herb-flour.png') }}" alt="Category Thumbnail">
                            <h3 class="category-title">{{ $item->category }}</h3>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bootstrap-tabs product-tabs">
                    <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                        <h3>Produk</h3>
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                @foreach ($products as $item)
                                <div class="col">
                                    <div class="product-item">
                                        <a href="#" class="btn-wishlist">
                                            <svg width="24" height="24">
                                                <use xlink:href="#heart"></use>
                                            </svg>
                                        </a>

                                        <figure>
                                            <a href="#" title="Product Title">
                                                <img src="{{ asset('storage/'.$item->gambar) }}" class="tab-image" alt="{{ $item->nama }}">
                                            </a>
                                        </figure>

                                        <h3>{{ $item->nama }}</h3>
                                        <span class="qty">Kategori</span>
                                        <span class="rating">
                                            <svg width="10" height="10" class="text-primary"></svg>
                                            {{ $item->category->category }}
                                        </span>
                                        <span class="price">Rp. {{ number_format($item->harga, 0, ',', '.') }}</span>

                                        <form action="{{ route('order.create') }}" method="POST" class="mt-2" style="{{ $item->stok == 0 ? 'display: none;' : '' }}">
                                            @csrf
                                            <input type="hidden" name="items[0][product_id]" value="{{ $item->id }}">

                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="input-group product-qty" style="max-width: 120px;">
                                                    <input type="number" name="items[0][quantity]" class="form-control input-number" value="1" min="1" max="{{ $item->stok }}" required>
                                                </div>

                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    Masukan ke Keranjang
                                                    <svg width="16" height="16">
                                                        <use xlink:href="#cart"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection