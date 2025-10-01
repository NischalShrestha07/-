@extends('layouts.admin', ['page' => 'Add Category'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Category</h3>
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
                    <a href="{{ route('admin.categories.index') }}">
                        <div class="text-tiny">Categories</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Add Category</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.categories.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
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
                    <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category name" name="name"
                        value="{{ old('name') }}" aria-required="true" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category slug" name="slug"
                        value="{{ old('slug') }}" aria-required="true" required>
                    <div class="text-tiny">Leave blank to auto-generate from name.</div>
                </fieldset>

                <fieldset class="category">
                    <div class="body-title mb-10">Parent Category</div>
                    <div class="select">
                        <select name="parent_id">
                            <option value="">None</option>
                            @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_id')==$cat->id ? 'selected' : '' }}>{{
                                $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="body-title">Upload Image</div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="" class="effect8" alt="Preview">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to
                                        browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview image
    document.getElementById('myFile').addEventListener('change', function(event) {
        const preview = document.getElementById('imgpreview');
        const file = event.target.files[0];
        if (file) {
            preview.style.display = 'block';
            preview.querySelector('img').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection