@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Coupons</h3>
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
                    <div class="text-tiny">All Coupons</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{ route('admin.coupons.index') }}">
                        <fieldset class="name">
                            <input type="text" placeholder="Search coupons..." name="search"
                                value="{{ request('search') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.coupons.create') }}"><i
                        class="icon-plus"></i>Add New</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min Order Amount</th>
                                <th>Expiry Date</th>
                                <th>Usage Limit</th>
                                <th>Used Count</th>
                                <th>Max Discount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coupons as $index => $coupon)
                            <tr>
                                <td>{{ $coupons->firstItem() + $index }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ ucfirst($coupon->type) }}</td>
                                <td>
                                    {{ $coupon->type === 'fixed' ? '$' . number_format($coupon->value, 2) :
                                    $coupon->value . '%' }}
                                </td>
                                <td>{{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) :
                                    '-' }}</td>
                                <td>{{ $coupon->expiry_date->format('Y-m-d') }}</td>
                                <td>{{ $coupon->usage_limit ?? '-' }}</td>
                                <td>{{ $coupon->used_count }}</td>
                                <td>{{ $coupon->max_discount ? '$' . number_format($coupon->max_discount, 2) : '-' }}
                                </td>
                                <td>{{ $coupon->status ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">No coupons found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</div>
@endsection