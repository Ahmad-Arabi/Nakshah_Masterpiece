@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('title')
    Admin : Products Management
@endsection

@section('content')
    <div class="container" style="max-height: 100%">
        <div class="my-3">
            <h3>
                <i class="bi bi-box-seam"></i>
                Products Management
            </h3>
        </div>

        {{-- Create Product & Modal --}}
        <div class="my-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                <i class="bi bi-plus-circle"></i>
                New Product
            </button>
        </div>
        {{-- Include the modal body --}}
        @include('admin.products.create')

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center alertDelete mt-3"
                role="alert">
                <div>
                    <i class="bi bi-check2-circle"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center alertDelete mt-3"
                role="alert">
                <div>
                    @foreach ($errors->all() as $error)
                        <p><i class="bi bi-exclamation-circle"></i> {{ $error }}</p>
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Spinner -->
        <div id="spinner" class="text-center my-5">

            <div class="loader text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

        </div>

        <!-- Products Table -->
        <div class="table-responsive" id="tableContainer" style="display: none;">
            @include('admin.products.table') 
        </div>
    </div>

@endsection

<script src="/js/admin.js"></script>
