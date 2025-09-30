@extends('layouts.admin', ['page' => 'Add Slider'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Slider</h3>
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
                    <a href="{{ route('admin.sliders.index') }}">
                        <div class="text-tiny">Sliders</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Add Slider</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.sliders.store') }}"
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
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Slider Title" name="title"
                        value="{{ old('title') }}" aria-required="true" required>
                    <div class="text-tiny">Max 255 characters.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Description</div>
                    <textarea class="flex-grow" placeholder="Slider Description"
                        name="description">{{ old('description') }}</textarea>
                    <div class="text-tiny">Max 500 characters.</div>
                </fieldset>

                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
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
                                <input type="file" id="myFile" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Alt Text</div>
                    <input class="flex-grow" type="text" placeholder="Image Alt Text (for SEO)" name="alt_text"
                        value="{{ old('alt_text') }}">
                    <div class="text-tiny">Max 255 characters, for accessibility and SEO.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Link</div>
                    <input class="flex-grow" type="url" placeholder="Link (e.g., https://example.com)" name="link"
                        value="{{ old('link') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Order</div>
                    <input class="flex-grow" type="number" placeholder="Display Order" name="order"
                        value="{{ old('order') }}" min="0">
                    <div class="text-tiny">Leave blank to append to the end.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Status <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="status" required>
                            <option value="1" {{ old('status', 1)==1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status')==0 ? 'selected' : '' }}>Inactive</option>
                        </select>
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