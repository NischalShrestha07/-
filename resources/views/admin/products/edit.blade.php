@extends('layouts.admin', ['page' => 'Edit Product'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.products.index') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Edit Product</div>
                </li>
            </ul>
        </div>

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.products.update', $product->id) }}">
            @csrf
            @method('PUT')

            <div class="wg-box">
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
                    <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" name="name" value="{{ old('name', $product->name) }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" name="slug" value="{{ old('slug', $product->slug) }}" required>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <select name="category_id" required>
                            <option value="">Choose category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) ==
                                $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <select name="brand_id" required>
                            <option value="">Choose Brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ?
                                'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>

                <fieldset>
                    <div class="body-title mb-10">Short Description</div>
                    <textarea name="short_description"
                        required>{{ old('short_description', $product->short_description) }}</textarea>
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Description</div>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </fieldset>
            </div>

            <div class="wg-box">
                <fieldset>
                    <div class="body-title mb-10">Upload Main Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div id="imgpreview" style="display:none">
                            <img src="" class="effect8" alt="Preview">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="mainImage">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to
                                        browse</span></span>
                                <input type="file" id="mainImage" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="galleryImages">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to
                                        browse</span></span>
                                <input type="file" id="galleryImages" name="images[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" step="0.01" placeholder="Enter regular price"
                            name="regular_price" value="{{ old('regular_price',$product->regular_price) }}"
                            aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price</div>
                        <input class="mb-10" type="number" step="0.01" placeholder="Enter sale price" name="sale_price"
                            value="{{ old('sale_price',$product->sale_price) }}">
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="sku"
                            value="{{ old('sku',$product->sku) }}" aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" placeholder="Enter quantity" name="quantity"
                            value="{{ old('quantity',$product->quantity) }}" aria-required="true" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock Status <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select name="stock_status" required>
                                <option value="instock" {{ old('stock_status')=='instock' ? 'selected' : '' }}>In Stock
                                </option>
                                <option value="outofstock" {{ old('stock_status')=='outofstock' ? 'selected' : '' }}>Out
                                    of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select name="featured" required>
                                <option value="0" {{ old('featured',$product->featured)=='0' ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ old('featured',$product->featured)=='1' ? 'selected' : '' }}>Yes
                                </option>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection