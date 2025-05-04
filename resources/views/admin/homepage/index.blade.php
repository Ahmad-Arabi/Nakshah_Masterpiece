@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="/css/admin.css">
@endsection

@section('title')
    Admin : Homepage
@endsection

@section('content')
                  {{-- Table --}}
              <div class="container" style="max-height: 100%">
                <div class="my-3">
                  <h3>
                    <i class="bi bi-speedometer2"></i>
                    Dashoard
                  </h3>
                </div>
                
                <!-- Spinner -->
                <div id="spinner" class="text-center my-5">
                  <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div>
                </div>

                <!-- User Table -->
                <div class="table-responsive" id="tableContainer" style="display: none;">
                  @include('admin.homepage.table') <!-- Dynamically load table -->
                </div>

                @endsection
                <script src="/js/admin.js"></script>  