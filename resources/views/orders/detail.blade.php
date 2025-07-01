@extends('layouts.user')
@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('orders.my')}}" class="btn btn-outline-secondary">
                &laquo; Kembali Ke Daftar Pesanan
            </a>
        </div>
    </div>


<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Pesanan #{{ $order->id }}</h4>
                <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-primary' }}">
                    {{ $order->status == 'completed' ? 'Selesai' : 'Menunggu Pembayaran' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tanggal Pesanan:</strong></p>
                        <p>{{ $order->created_at->format('d M Y, H:i')}}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status Pesanan:</strong></p>
                           <p>{{ $order->status == 'completed' ? 'Selesai' : 'Menunggu Pembayaran' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Produk yang Dipesan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th width="100">Gambar</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderProduct as $item)
                            <tr>
                                <td>
                                    <h6 class="mb-0">{{ $item->product->nama }}</h6>
                                </td>
                                <td>
                                    @if($item->product->gambar)
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" class="img-thumbnail" width="80">
                                    @else
                                    <div class="bg-light text-center p-2" style="width: 80px; height: 80px;">
                                        Tidak Ada Gambar
                                    </div>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->product->harga, 0, ',', '.')}}</td>
                                <td>
                                    @if($order->status == 'pending')
                                    <form action="{{ route('order.update-quantity')}}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="order_product_id" value="{{ $item->id }}">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stok }}"
                                        class="form-control form-control-sm" style="width: 60px">
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Perbarui</button>
                                    </form>
                                    <small class="text-muted d-block mt-1">Tersedia: {{ $item->product->stok }}</small>
                                    @else
                                    {{ $item->quantity }}
                                    @endif
                                </td>
                                <td>
                                    Rp {{ number_format($item->subtotal, 0, ',', '.')}}
                                    @if($order->status == 'pending')
                                    <form action="{{ route('order.remove-item')}}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="order_product_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Produk ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.')}}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Ringkasan Pesanan</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Jumlah item
                        <span>{{ $order->orderProduct->sum('quantity') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Harga
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.')}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Status Pesanan
                        <span>{{ $order->status == 'completed' ? 'Selesai' : 'Menunggu Pembayaran'}}</span>
                    </li>
                </ul>

                @if($order->status == 'pending')
                <div class="mt-3">
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                         <input type="hidden" name="order_id" value="{{ $order->id }}">
                          <button type="submit" class="btn btn-primary w-100">Bayar Sekarang</button>
                    </form>
                </div>
                @endif
            </div>
        </div>

         @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
        @endif
    </div>
</div>
</div>

@endsection