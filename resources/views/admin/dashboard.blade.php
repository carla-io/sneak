@extends('admin.layouts.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">SneakTech /</span> Charts </h4> -->
    
    <!-- Card for Sales Chart -->
    <div class="card mb-4" style="max-width: 600px; margin: auto;">
        <div class="card-header text-center">
            <h5 class="card-title mb-0">Sales Chart</h5>
        </div>
        <div class="card-body">
            <canvas id="salesChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Card for Product Pie Chart -->
    <div class="card mb-4" style="max-width: 600px; margin: auto;">
        <div class="card-header text-center">
            <h5 class="card-title mb-0">Product Pie Chart</h5>
        </div>
        <div class="card-body">
            <canvas id="productPieChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Card for Users Line Chart -->
    <div class="card mb-4" style="max-width: 600px; margin: auto;">
        <div class="card-header text-center">
            <h5 class="card-title mb-0">Sales Line Chart</h5>
        </div>
        <div class="card-body">
            <canvas id="salesLineChart" width="600" height="400"></canvas>
        </div>
    </div>
</div>
@endsection
