@extends('layouts.template')

@php
    $user = Auth::user();
@endphp

@section('content')
<div class="container mt-5">
    <div id="checkoutWizard">
    <div class="card">
    <div class="card-header">
        <!-- Step 1: Cart Items -->
        <div id="step1" class="step">
            <h2>Step 1: Your Cart</h2>
            <table class="table table-bordered">
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
            <br>
            <button id="backToHome" class="btn btn-secondary">Back</button>
            <button id="toStep2" class="btn btn-primary">Next</button>
        </div>

        <!-- Step 2: Shipping Information -->
        <div id="step2" class="step" style="display: none;">
            <h2>Step 2: Shipping Information</h2>
            <div id="user-info">
                <p><strong>User Id:</strong> <span id="ID"></span></p>
                <p><strong>Username:</strong> <span id="username"></span></p>
                <p><strong>Email:</strong> <span id="email"></span></p>
                <p><strong>Address:</strong> <span id="address"></span></p>
                <p><strong>Phone Number:</strong> <span id="phone_number"></span></p>
            </div>

            <h3>Select Payment Method:</h3>
            <div class="form-check" id="payment-method">
                <input class="form-check-input" type="radio" name="paymentMethod" id="gcash" value="gcash">
                <label class="form-check-label" for="gcash">GCash</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod">
                <label class="form-check-label" for="cod">Cash on Delivery</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" id="card" value="card">
                <label class="form-check-label" for="card">Card</label>
            </div> 
            <br>

            <button id="backToStep1" class="btn btn-secondary">Back</button>
            <button id="toStep3" class="btn btn-primary">Next</button>
        </div>

        <!-- Step 3: Order Summary -->
        <div id="step3" class="step" style="display: none;">
            <h2>Step 3: Order Summary</h2>
            <pre id="summaryDetails"></pre>
            <button id="backToStep2" class="btn btn-secondary">Back</button>
            <button id="checkout" class="btn btn-success">Complete Checkout</button>
        </div>
    </div>
</div>
</div>
</div>

<script>
    document.getElementById('backToHome').addEventListener('click', function() {
        window.location.href = '{{ route('home') }}';
    });
</script>
@endsection
