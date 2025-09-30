@extends('layouts.admin',['page'=>'Brands'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Brands</h3>
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
                    <div class="text-tiny">Brands</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{ route('admin.brands.index') }}">
                        <fieldset class="name">
                            <input type="text" placeholder="Search brands..." name="search"
                                value="{{ request('search') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.brands.create') }}"><i class="icon-plus"></i>Add
                    New</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $index => $brand)
                            <tr>
                                <td>{{ $brands->firstItem() + $index }}</td>
                                <td>
                                    <img src="{{ $brand->image ? asset('storage/' . $brand->image) : asset('images/placeholder.png') }}"
                                        alt="{{ $brand->name }}" width="50">
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->slug }}</td>
                                <td>{{ Str::limit($brand->description, 50, '...') }}</td>
                                <td>{{ $brand->status ? 'Active' : 'Inactive' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.products.index', ['brand_id' => $brand->id]) }}">{{
                                        $brand->products_count }}</a>
                                </td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.brands.edit', $brand) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this brand?');">
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
                                <td colspan="8" class="text-center">No brands found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</div>
@endsection