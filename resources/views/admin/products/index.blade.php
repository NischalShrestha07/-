@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>
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
                    <div class="text-tiny">All Products</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{ route('admin.products.index') }}">
                        <fieldset class="name">
                            <input type="text" placeholder="Search products..." name="search"
                                value="{{ request('search') }}" aria-required="true">
                        </fieldset>
                        <select name="category_id">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id')==$category->id ? 'selected' :
                                '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <select name="brand_id">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id')==$brand->id ? 'selected' : '' }}>{{
                                $brand->name }}</option>
                            @endforeach
                        </select>
                        <select name="stock_status">
                            <option value="">All Stock</option>
                            <option value="instock" {{ request('stock_status')=='instock' ? 'selected' : '' }}>In Stock
                            </option>
                            <option value="outofstock" {{ request('stock_status')=='outofstock' ? 'selected' : '' }}>Out
                                of Stock</option>
                        </select>
                        <select name="featured">
                            <option value="">All Featured</option>
                            <option value="1" {{ request('featured')=='1' ? 'selected' : '' }}>Featured</option>
                            <option value="0" {{ request('featured')=='0' ? 'selected' : '' }}>Not Featured</option>
                        </select>
                        <input type="number" name="price_min" placeholder="Min Price"
                            value="{{ request('price_min') }}">
                        <input type="number" name="price_max" placeholder="Max Price"
                            value="{{ request('price_max') }}">
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.products.create') }}"><i
                        class="icon-plus"></i>Add New</a>
                <a class="tf-button style-1 w208" href="{{ route('admin.products.export') }}"><i
                        class="icon-download"></i>Export CSV</a>
            </div>
            <form method="POST" action="{{ route('admin.products.bulk') }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Sale Price</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Featured</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Variants</th>
                                <th>Tags</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                            <tr>
                                <td><input type="checkbox" name="product_ids[]" value="{{ $product->id }}"></td>
                                <td>{{ $products->firstItem() + $index }}</td>
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}"
                                            alt="{{ $product->name }}" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="body-title-2">{{
                                            $product->name }}</a>
                                        <div class="text-tiny mt-3">{{ $product->short_description }}</div>
                                    </div>
                                </td>
                                <td>${{ number_format($product->regular_price, 2) }}</td>
                                <td>{{ $product->sale_price ? '$' . number_format($product->sale_price, 2) : '-' }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>{{ $product->brand->name ?? '-' }}</td>
                                <td>{{ $product->featured ? 'Yes' : 'No' }}</td>
                                <td>{{ $product->stock_status }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->variants->count() }}</td>
                                <td>{{ $product->tags->pluck('name')->implode(', ') }}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.products.edit', $product) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                                <td colspan="14" class="text-center">No products found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->links() }}
                </div>
                <div class="bulk-actions mt-3">
                    <select name="action">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="submit" class="tf-button">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        document.querySelectorAll('input[name="product_ids[]"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection