@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order #{{ $order->id }} Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}">
                        <div class="text-tiny">Orders</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Order Details</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Items</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.orders.index') }}">Back</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">SKU</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Options</th>
                            <th class="text-center">Return Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->items as $item)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.png') }}"
                                        alt="{{ $item->product->name }}" class="image">
                                </div>
                                <div class="name">
                                    <a href="{{ route('admin.products.show', $item->product) }}" target="_blank"
                                        class="body-title-2">{{ $item->product->name }}</a>
                                </div>
                            </td>
                            <td class="text-center">${{ number_format($item->price, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ $item->sku }}</td>
                            <td class="text-center">{{ $item->product->category->name ?? '-' }}</td>
                            <td class="text-center">{{ $item->product->brand->name ?? '-' }}</td>
                            <td class="text-center">{{ $item->options ?? '-' }}</td>
                            <td class="text-center">{{ $item->return_status ?? 'No' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.show', $item->product) }}">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Shipping Address</h5>
            @if ($order->address)
            <div class="my-account__address-item col-md-6">
                <div class="my-account__address-item__detail">
                    <p>{{ $order->address->name }}</p>
                    <p>{{ $order->address->address_line1 }}</p>
                    @if ($order->address->address_line2)
                    <p>{{ $order->address->address_line2 }}</p>
                    @endif
                    <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>
                    <p>{{ $order->address->country }}</p>
                    <p>Mobile: {{ $order->address->phone }}</p>
                </div>
            </div>
            @else
            <p>No shipping address provided.</p>
            @endif
        </div>

        <div class="wg-box mt-5">
            <h5>Transactions</h5>
            <table class="table table-striped table-bordered table-transaction">
                <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td>${{ number_format($order->subtotal, 2) }}</td>
                        <th>Tax</th>
                        <td>${{ number_format($order->tax, 2) }}</td>
                        <th>Discount</th>
                        <td>${{ number_format($order->discount, 2) }} {{ $order->coupon ? '(' . $order->coupon->code .
                            ')' : '' }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <th>Payment Method</th>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <th>Status</th>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                        <th>Delivered Date</th>
                        <td>{{ $order->delivered_at ? $order->delivered_at->format('Y-m-d') : '-' }}</td>
                        <th>Cancelled Date</th>
                        <td>{{ $order->cancelled_at ? $order->cancelled_at->format('Y-m-d') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection