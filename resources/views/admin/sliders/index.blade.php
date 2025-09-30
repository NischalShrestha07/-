@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Sliders</h3>
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
                    <div class="text-tiny">All Sliders</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{ route('admin.sliders.index') }}">
                        <fieldset class="name">
                            <input type="text" placeholder="Search sliders..." name="search"
                                value="{{ request('search') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.sliders.create') }}"><i
                        class="icon-plus"></i>Add New</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sliders as $index => $slider)
                            <tr>
                                <td>{{ $sliders->firstItem() + $index }}</td>
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{ $slider->image ? asset('storage/' . $slider->image) : asset('images/placeholder.png') }}"
                                            alt="{{ $slider->alt_text ?? $slider->title }}" class="image" width="100">
                                    </div>
                                </td>
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->description ?? '-' }}</td>
                                <td>{{ $slider->link ? Str::limit($slider->link, 30) : '-' }}</td>
                                <td>{{ $slider->order }}</td>
                                <td>{{ $slider->status ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.sliders.edit', $slider) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this slider?');">
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
                                <td colspan="8" class="text-center">No sliders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $sliders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection