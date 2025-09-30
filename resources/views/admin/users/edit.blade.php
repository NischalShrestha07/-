@extends('layouts.admin', ['page' => 'Edit User'])
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit User</h3>
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
                    <a href="{{ route('admin.users.index') }}">
                        <div class="text-tiny">Users</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit User</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.users.update', $user) }}"
                enctype="multipart/form-data">
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
                    <div class="body-title">Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="User Name" name="name"
                        value="{{ old('name', $user->name) }}" aria-required="true" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Email <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="email" placeholder="Email Address" name="email"
                        value="{{ old('email', $user->email) }}" aria-required="true" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Password</div>
                    <input class="flex-grow" type="password" placeholder="New Password (leave blank to keep unchanged)"
                        name="password">
                    <div class="text-tiny">Minimum 8 characters.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Confirm Password</div>
                    <input class="flex-grow" type="password" placeholder="Confirm New Password"
                        name="password_confirmation">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Phone</div>
                    <input class="flex-grow" type="text" placeholder="Phone Number" name="phone"
                        value="{{ old('phone', $user->phone) }}">
                </fieldset>

                <fieldset>
                    <div class="body-title">Profile Image</div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview"
                            style="{{ $user->profile_image ? 'display:block' : 'display:none' }}">
                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}"
                                class="effect8" alt="{{ $user->name }}">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to
                                        browse</span></span>
                                <input type="file" id="myFile" name="profile_image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Role <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="role" required>
                            <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : ''
                                }}>Customer</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                        </select>
                    </div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Status <span class="tf-color-1">*</span></div>
                    <div class="select flex-grow">
                        <select name="status" required>
                            <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Inactive
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