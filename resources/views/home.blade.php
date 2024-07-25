@extends('layouts.template')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" id="searchBar" class="form-control" placeholder="Search for products...">
        </div>
        <div class="col-md-6">
            <select id="categorySelect" class="form-select">
                <option value="all">All Categories</option>
                <!-- Dynamically populated categories -->
            </select>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row" id="productContainer">
        <!-- Products will be appended here dynamically -->
    </div>
</div>

<!-- Floating Cart Button -->
<button id="floatingCartButton" class="btn btn-primary position-fixed bottom-0 end-0 m-3 shadow-lg">
    <i class="bi bi-cart"></i> View Cart (<span id="cartCount">0</span>)
</button>

@endsection

@section('styles')
<style>
    /* Custom styles for the page */
    .form-control {
        border-radius: 0.5rem;
    }

    .form-select {
        border-radius: 0.5rem;
    }

    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-card-body {
        padding: 1rem;
    }

    .product-card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .product-card-price {
        color: #007bff;
        font-size: 1.125rem;
        margin-top: 0.5rem;
    }

    #floatingCartButton {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    #floatingCartButton:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 767.98px) {
        #floatingCartButton {
            padding: 0.5rem 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Custom scripts for dynamically loading products
</script>
@endsection
