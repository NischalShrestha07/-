@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Orders</h3>
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
                    <div class="text-tiny">Orders</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{ route('admin.orders.index') }}">
                        <fieldset class="name">
                            <input type="text" placeholder="Search orders..." name="search"
                                value="{{ request('search') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:70px">Order No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                            <tr>
                                <td class="text-center">{{ $order->id }}</td>
                                <td class="text-center">{{ $order->user->name }}</td>
                                <td class="text-center">{{ $order->user->phone ?? '-' }}</td>
                                <td class="text-center">${{ number_format($order->subtotal, 2) }}</td>
                                <td class="text-center">${{ number_format($order->tax, 2) }}</td>
                                <td class="text-center">${{ number_format($order->discount, 2) }}</td>
                                <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="form-control">
                                            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled']
                                            as $status)
                                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' :
                                                '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="text-center">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                                <td class="text-center">{{ $order->delivered_at ? $order->delivered_at->format('Y-m-d')
                                    : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}">
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
                                <td colspan="12" class="text-center">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection