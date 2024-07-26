@extends('layouts.template')

@php
    $user = Auth::user();
@endphp

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>Shopping Cart</h1>
        </div>
        <div class="card-body">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="cartTableBody">
                    <!-- Cart items will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <button id="checkout" class="btn btn-success">Proceed to Checkout</button>
        </div>
    </div>
</div>

@endsection



