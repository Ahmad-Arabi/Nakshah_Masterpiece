@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('title')
    Admin : Categories Management
@endsection

@section('content')
    <div class="container" style="max-height: 100%">
        <div class="my-3">
            <h3>
                <i class="bi bi-tags"></i>
                Categories Management
            </h3>
        </div>

        {{-- Create Category & Modal --}}
        <div class="my-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="bi bi-folder-plus"></i>
                New Category
            </button>
        </div>
        {{-- Include the modal body --}}
        @include('admin.categories.create')

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
            </div>

        </div>

        <!-- Categories Table -->
        <div class="table-responsive" id="tableContainer" style="display: none;">
            @include('admin.categories.table')
        </div>
        

    @endsection

    <script src="/js/admin.js"></script>
