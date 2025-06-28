@extends('layouts.admin')
@section('content')
<a href="{{ route('admin.category.create')}}" class="btn btn-primary">Tambah Data</a>
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
<div class="table-responsive">

<table class="table">
    <thead class="bg-info text-white">
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Slug</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($category as $data)
      
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->category }}</td>
            <td>{{ $data->slug }}</td>
            <td><a href="{{ route('admin.category.edit', $data->id)}}" class="btn btn-success">Edit</a> | 
           <form method="POST" action="{{ route('admin.category.destroy', $data->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit"  class="btn btn-danger">Delete</button>
            </form>
        </td>
        </tr>
          @endforeach
    </tbody>
</table>
</div>

@endsection