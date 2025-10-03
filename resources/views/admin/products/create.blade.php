@extends('layouts.admin', ['page' => 'Add Product'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
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
                    <a href="{{ route('admin.products.index') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Add Product</div>
                </li>
            </ul>
        </div>

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.products.store') }}">
            @csrf
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
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name"
                        value="{{ old('name') }}" aria-required="true" required>
                    <div class="text-tiny">Do not exceed 255 characters.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug" name="slug"
                        value="{{ old('slug') }}" aria-required="true" required>
                    <div class="text-tiny">Do not exceed 255 characters. Leave blank to auto-generate.</div>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_id" required>
                                <option value="">Choose category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' :
                                    '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="brand_id" required>
                                <option value="">Choose Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id ? 'selected' : '' }}>{{
                                    $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description"
                        aria-required="true" required>{{ old('short_description') }}</textarea>
                    <div class="text-tiny">Do not exceed 500 characters.</div>
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description"
                        placeholder="Description">{{ old('description') }}</textarea>
                </fieldset>

                <fieldset class="tags">
                    <div class="body-title mb-10">Tags</div>
                    <select name="tags[]" multiple>
                        @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{
                            $tag->name }}</option>
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="meta">
                    <div class="body-title mb-10">Meta Title</div>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}">
                </fieldset>

                <fieldset class="meta">
                    <div class="body-title mb-10">Meta Description</div>
                    <textarea name="meta_description">{{ old('meta_description') }}</textarea>
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
                            name="regular_price" value="{{ old('regular_price') }}" aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price</div>
                        <input class="mb-10" type="number" step="0.01" placeholder="Enter sale price" name="sale_price"
                            value="{{ old('sale_price') }}">
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="sku" value="{{ old('sku') }}"
                            aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" placeholder="Enter quantity" name="quantity"
                            value="{{ old('quantity') }}" aria-required="true" required>
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
                                <option value="0" {{ old('featured')=='0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('featured')=='1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="variants">
                    <div class="body-title mb-10">Variants</div>
                    <div id="variants-container">
                        <div class="variant-row">
                            <input type="text" name="variants[0][size]" placeholder="Size">
                            <input type="text" name="variants[0][color]" placeholder="Color">
                            <input type="number" step="0.01" name="variants[0][price]" placeholder="Price">
                            <input type="number" name="variants[0][quantity]" placeholder="Quantity">
                            <button type="button" class="remove-variant">Remove</button>
                        </div>
                    </div>
                    <button type="button" id="add-variant">Add Variant</button>
                </fieldset>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let variantCount = 1;
    document.getElementById('add-variant').addEventListener('click', function() {
        const container = document.getElementById('variants-container');
        const row = document.createElement('div');
        row.className = 'variant-row';
        row.innerHTML = `
            <input type="text" name="variants[${variantCount}][size]" placeholder="Size">
            <input type="text" name="variants[${variantCount}][color]" placeholder="Color">
            <input type="number" step="0.01" name="variants[${variantCount}][price]" placeholder="Price">
            <input type="number" name="variants[${variantCount}][quantity]" placeholder="Quantity">
            <button type="button" class="remove-variant">Remove</button>
        `;
        container.appendChild(row);
        variantCount++;
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-variant')) {
            event.target.parentElement.remove();
        }
    });

    // Preview main image
    document.getElementById('mainImage').addEventListener('change', function(event) {
        const preview = document.getElementById('imgpreview');
        const file = event.target.files[0];
        if (file) {
            preview.style.display = 'block';
            preview.querySelector('img').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection