@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="/css/admin.css">
@endsection

@section('title')
    Admin : Charts
@endsection

@section('content')

<div class="container">
    <div class="my-3">
        <h3><i class="bi bi-graph-up"></i> Charts</h3>
    </div>

    <!-- Charts section -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <div class="card chart w-100 h-100">
                    <div class="card-body" >
                        {!! $ordersChart->container() !!}
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card chart w-100 h-75">
                    <div class="card-body">
                        {!! $userGrowthChart->container() !!}
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card chart w-100 h-75">
                    <div class="card-body">
                        {!! $revenueChart->container() !!}
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="card chart w-100 h-75">

                    <div class="card-body">
                        {!! $stockChart->container() !!}
                    </div>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev top-50" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next top-50" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/larapex-charts@latest/dist/larapex-charts.min.js"></script>
<script src="/js/admin.js"></script>
<!-- Load chart scripts -->
{!! $ordersChart->script() !!}
{!! $userGrowthChart->script() !!}
{!! $revenueChart->script() !!}
{!! $stockChart->script() !!}

@endsection