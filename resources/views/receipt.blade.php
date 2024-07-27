@extends('layouts.template')

@section('content')

<div class="receipt-container">
        <div class="receipt-header">
            <h1>Order Receipt</h1>
        </div>
        <div class="receipt-details">
            <p><span>Order ID:</span> {{ $order->id }}</p>
            <p><span>Product:</span> {{ $order->product_name }}</p>
            <p><span>Quantity:</span> {{ $order->quantity }}</p>
            <p><span>Total Price:</span> ${{ $order->total_price }}</p>
            <p><span>Status:</span> {{ $order->status }}</p>
            <p><span>Shipper:</span> {{ $order->shipper ? $order->shipper->name : 'Not Assigned' }}</p>
        </div>
        <div class="receipt-footer">
            Thank you for your order!
        </div>
    </div>



@endsection

@section('styles')
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .receipt-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .receipt-details {
            margin-bottom: 20px;
        }

        .receipt-details p {
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }

        .receipt-details p span {
            font-weight: bold;
            color: #333;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #777;
        }
    </style>

@endsection