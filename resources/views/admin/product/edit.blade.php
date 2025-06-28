@extends('layouts.admin')
@section('content')
<div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-3">Basic Form</h4>
                  <form action="{{ route('admin.product.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="nama" value="{{$product->nama}}" id="tb-fname" placeholder="Enter Name here" required>
                          <label for="tb-fname">Nama Product</label>
                        </div>
                         <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="deskripsi" value="{{$product->deskripsi}}" id="tb-fname" placeholder="Enter Name here" required>
                          <label for="tb-fname">Deskripsi Product</label>
                        </div>
                         <div class="form-floating mb-3">
                          <input type="number" class="form-control" name="harga" value="{{$product->harga}}" id="tb-fname" placeholder="Enter Name here" required>
                          <label for="tb-fname">Harga Product</label>
                        </div>
                         <div class="form-floating mb-3">
                          <input type="number" class="form-control" name="stok" value="{{$product->stok}}" id="tb-fname" placeholder="Enter Name here" required>
                          <label for="tb-fname">Stock Product</label>
                        </div>
                         <div class="form-floating mb-3">
                          <input type="file" class="form-control" name="gambar" id="tb-fname" accept="image/*" required>
                          <label for="tb-fname">Photo Product</label>
                          <small class="text-muted">Kosongkan</small>
                          @if($product->gambar)
                          <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->gambar) }}" class="img-thumbanil" style="max-width: 300px;">
                          </div>
                          @endif
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                         <label for="tb-fname">Category Product</label>
                        <select class="form-select mr-sm-2" name='category_id'>
                              @foreach ($categories as $data)
                              <option value="{{ $data->id }}" {{$product->category_id == $data->id ? 'selected' : ''}}>{{ $data->category }}</option>
                              @endforeach
                       </select>
                         </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="d-md-flex align-items-center">
                          <div class="ms-auto mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary hstack gap-6">
                              <i class="ti ti-send fs-4"></i>
                              Submit
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
@endsection