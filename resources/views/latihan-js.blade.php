@extends('layouts.admin')
@section('content')
<div class="container">
    <h1>Latihan javascript</h1>
   <button id="alertButton" class="btn btn-primary">Click</button>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('alertButton')
        .addEventListener('click', () => alert('Button was clicked'));
    });
</script>
@endpush