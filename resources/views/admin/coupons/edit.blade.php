@extends('layouts.admin', ['page' => 'Edit Coupon'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Coupon</h3>
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
                    <a href="{{ route('admin.coupons.index') }}">
                        <div class="text-tiny">Coupons</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Coupon</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST"
                action="{{ route('admin.coupons.update', $coupon) }}">
                @csrf
                @method('PUT')
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <fieldset class="name">
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Code (e.g., OFF10)" name="code"
                        value="{{ old('code', $coupon->code) }}" aria-required="true" required>
                    <div class="text-tiny">Max 20 characters, will be converted to uppercase.</div>
                </fieldset>

                <fieldset class="category">
                    <div class="body-title">Coupon Type <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="type" required>
                            <option value="">Select Type</option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed
                            </option>
                            <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : ''
                                }}>Percentage</option>
                        </select>
                    </div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="number" step="0.01" placeholder="Coupon Value (e.g., 10.00)"
                        name="value" value="{{ old('value', $coupon->value) }}" aria-required="true" required>
                    <div class="text-tiny">Enter amount for fixed or percentage for percentage type.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Minimum Order Amount</div>
                    <input class="flex-grow" type="number" step="0.01" placeholder="Minimum Order Amount (e.g., 100.00)"
                        name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Maximum Discount</div>
                    <input class="flex-grow" type="number" step="0.01"
                        placeholder="Max Discount for Percentage (e.g., 50.00)" name="max_discount"
                        value="{{ old('max_discount', $coupon->max_discount) }}">
                    <div class="text-tiny">Applicable for percentage coupons only.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Usage Limit</div>
                    <input class="flex-grow" type="number" placeholder="Usage Limit (e.g., 100)" name="usage_limit"
                        value="{{ old('usage_limit', $coupon->usage_limit) }}">
                    <div class="text-tiny">Leave blank for unlimited uses.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date"
                        value="{{ old('expiry_date', $coupon->expiry_date->format('Y-m-d')) }}" aria-required="true"
                        required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Status <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="status" required>
                            <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection