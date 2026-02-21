@extends('backend.master')

@section('title', 'Dashboard | Edit Product')

@push('styles')
    <style>
        .color-box {
            width: 28px;
            height: 28px;
            display: inline-block;
            border-radius: 6px;
            border: 2px solid #e0e0e0;
            vertical-align: middle;
            margin-right: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .color-option-card {
            background: #ffffff;
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .color-option-card:hover {
            border-color: #6c757d;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .color-option-card.selected {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-color: #28a745;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.25);
        }

        .color-option-card .form-check {
            margin: 0;
            padding: 0;
        }

        .color-option-card .form-check-input {
            display: none;
        }

        .color-option-card .form-check-label {
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
            color: #495057;
            margin: 0;
            width: 100%;
        }

        .color-option-card.selected .form-check-label {
            color: #1e7e34;
        }

        /* Featured Product Toggle */
        .featured-toggle-wrapper {
            display: inline-flex;
            align-items: center;
            padding: 15px 25px;
            background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
            border: 2px solid #ffc107;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }

        .featured-toggle-wrapper:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.35);
        }

        .featured-toggle-wrapper.active {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
            border-color: #ff9800;
            box-shadow: 0 6px 25px rgba(255, 152, 0, 0.4);
        }

        .featured-toggle-wrapper .star-icon {
            font-size: 24px;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        .featured-toggle-wrapper:not(.active) .star-icon {
            opacity: 0.5;
        }

        .featured-toggle-wrapper.active .star-icon {
            animation: starPulse 1s ease-in-out infinite;
        }

        .featured-toggle-wrapper .toggle-text {
            font-weight: 600;
            font-size: 16px;
            color: #856404;
        }

        .featured-toggle-wrapper .toggle-switch {
            width: 50px;
            height: 26px;
            background: #dee2e6;
            border-radius: 13px;
            margin-left: 15px;
            position: relative;
            transition: all 0.3s ease;
        }

        .featured-toggle-wrapper.active .toggle-switch {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        }

        .featured-toggle-wrapper .toggle-switch::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .featured-toggle-wrapper.active .toggle-switch::after {
            left: 26px;
        }

        .featured-toggle-wrapper input[type="checkbox"] {
            display: none;
        }

        @keyframes starPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
        }

        .color-option-card .check-icon {
            display: none;
            margin-left: auto;
            color: #28a745;
            font-size: 18px;
        }

        .color-option-card.selected .check-icon {
            display: inline-block;
        }

        .gallery-image {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .gallery-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .gallery-image .delete-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-image .delete-btn:hover {
            background: #c82333;
        }

        .new-image-preview {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .new-image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #28a745;
        }

        .new-image-preview .remove-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            cursor: pointer;
            font-size: 12px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .new-image-preview .remove-btn:hover {
            background: #c82333;
        }
    </style>
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Product</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form action="{{ route('product.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Category --}}
                            <div class="col-md-6 mb-3">
                                <label for="buy_category_id" class="form-label">Category <span
                                        class="text-danger">*</span></label>
                                <select name="buy_category_id" id="buy_category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ ($data->buySubcategory->buy_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Subcategory --}}
                            <div class="col-md-6 mb-3">
                                <label for="buy_subcategory_id" class="form-label">Subcategory <span
                                        class="text-danger">*</span></label>
                                <select name="buy_subcategory_id" id="buy_subcategory_id" class="form-control">
                                    <option value="">Select Subcategory</option>
                                    @foreach ($subcategories as $subcategory)
                                        @if ($subcategory->buy_category_id == ($data->buySubcategory->buy_category_id ?? ''))
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('buy_subcategory_id', $data->buy_subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('buy_subcategory_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Product Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $data->name) }}" placeholder="Enter product name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Condition --}}
                            <div class="col-md-3 mb-3">
                                <label for="condition_id" class="form-label">Condition</label>
                                <select name="condition_id" id="condition_id" class="form-control">
                                    <option value="">Select Condition</option>
                                    @foreach ($conditions as $condition)
                                        <option value="{{ $condition->id }}"
                                            {{ old('condition_id', $data->condition_id) == $condition->id ? 'selected' : '' }}>
                                            {{ $condition->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('condition_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Storage --}}
                            @php
                                $selectedStorageId = $data->storages->first()?->id;
                            @endphp
                            <div class="col-md-3 mb-3">
                                <label for="storage_id" class="form-label">Storage</label>
                                <select name="storage_id" id="storage_id" class="form-control">
                                    <option value="">Select Storage</option>
                                    @foreach ($storages as $storage)
                                        <option value="{{ $storage->id }}"
                                            {{ old('storage_id', $selectedStorageId) == $storage->id ? 'selected' : '' }}>
                                            {{ (int) $storage->capacity }} {{ $storage->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('storage_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Stock --}}
                            <div class="col-md-3 mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control" min="0"
                                    value="{{ old('stock', $data->stock) }}" placeholder="Enter stock">
                                @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="col-md-3 mb-3">
                                <label for="price" class="form-label">Price (€) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01"
                                    min="0" value="{{ old('price', $data->price) }}" placeholder="Enter price">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Discount Price --}}
                            <div class="col-md-3 mb-3">
                                <label for="discount_price" class="form-label">Discount Price (€)</label>
                                <input type="number" name="discount_price" id="discount_price" class="form-control"
                                    step="0.01" min="0"
                                    value="{{ old('discount_price', $data->discount_price) }}"
                                    placeholder="Enter discount price">
                                @error('discount_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Old Price --}}
                            <div class="col-md-3 mb-3">
                                <label for="old_price" class="form-label">Old Price (€)</label>
                                <input type="number" name="old_price" id="old_price" class="form-control"
                                    step="0.01" min="0"
                                    value="{{ old('old_price', $data->old_price) }}" placeholder="Enter old price">
                                @error('old_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control ck-editor" rows="4"
                                placeholder="Enter product description">{{ old('description', $data->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Thumbnail Image --}}
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Thumbnail Image</label>
                                <input type="file" name="image" id="image" class="form-control dropify"
                                    accept="image/*" data-default-file="{{ asset($data->thumbnail) }}">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Gallery Images --}}
                            <div class="col-md-6 mb-3">
                                <label for="images" class="form-label">Add More Gallery Images</label>
                                <input type="file" name="images[]" id="images" class="form-control"
                                    accept="image/*" multiple>
                                <small class="text-muted">You can select multiple images</small>
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                {{-- New Images Preview --}}
                                <div class="mt-3" id="new-images-preview-container" style="display: none;">
                                    <label class="form-label text-success">New Images to Upload</label>
                                    <div id="new-images-preview"></div>
                                </div>

                                {{-- Existing Gallery Images --}}
                                @if ($data->images->count() > 0)
                                    <div class="mt-3">
                                        <label class="form-label">Current Gallery Images</label>
                                        <div>
                                            @foreach ($data->images as $image)
                                                <div class="gallery-image">
                                                    <img src="{{ asset($image->image) }}" alt="Gallery Image">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Is Featured --}}
                        <h5 class="mb-3"># If you want to make this product featured then check the box</h5>
                        <div class="mb-3">
                            <label class="featured-toggle-wrapper {{ old('is_featured', $data->is_featured) ? 'active' : '' }}" onclick="toggleFeatured(this)">
                                <span class="star-icon">⭐</span>
                                <span class="toggle-text">Featured Product</span>
                                <span class="toggle-switch"></span>
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $data->is_featured) ? 'checked' : '' }}>
                            </label>
                        </div>

                        <hr>
                        <h5 class="mb-3">Colors</h5>
                        @php
                            $selectedColors = $data->colors->pluck('id')->toArray();
                        @endphp
                        <div class="row">
                            @foreach ($colors as $color)
                                <div class="col-md-3 mb-3">
                                    <div class="color-option-card {{ in_array($color->id, $selectedColors) ? 'selected' : '' }}"
                                        onclick="toggleColorSelection(this, {{ $color->id }})">
                                        <div class="form-check">
                                            <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                                id="color_{{ $color->id }}" class="form-check-input"
                                                {{ in_array($color->id, $selectedColors) ? 'checked' : '' }}>
                                            <label for="color_{{ $color->id }}" class="form-check-label">
                                                <span class="color-box"
                                                    style="background-color: {{ $color->code }}"></span>
                                                {{ $color->name }}
                                                <span class="check-icon"><i class="mdi mdi-check-circle"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>
                        <h5 class="mb-3">Protection Services</h5>
                        @php
                            $selectedProtectionServices = $data->protectionServices->pluck('id')->toArray();
                        @endphp
                        <div class="row">
                            @foreach ($protectionServices as $service)
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="protection_services[]" value="{{ $service->id }}"
                                            id="protection_{{ $service->id }}" class="form-check-input"
                                            {{ in_array($service->id, $selectedProtectionServices) ? 'checked' : '' }}>
                                        <label for="protection_{{ $service->id }}" class="form-check-label">
                                            {{ $service->name }} - €{{ number_format($service->price, 2) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>
                        <h5 class="mb-3">Accessories</h5>
                        @php
                            $selectedAccessories = $data->accessories->pluck('id')->toArray();
                        @endphp
                        <div class="row">
                            @foreach ($accessories as $accessory)
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="accessories[]" value="{{ $accessory->id }}"
                                            id="accessory_{{ $accessory->id }}" class="form-check-input"
                                            {{ in_array($accessory->id, $selectedAccessories) ? 'checked' : '' }}>
                                        <label for="accessory_{{ $accessory->id }}" class="form-check-label">
                                            {{ $accessory->name }} - €{{ number_format($accessory->price, 2) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>
                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@push('scripts')
    <script>
        // Toggle featured product
        function toggleFeatured(wrapper) {
            const checkbox = wrapper.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            wrapper.classList.toggle('active', checkbox.checked);
        }

        // Toggle color selection
        function toggleColorSelection(card, colorId) {
            const checkbox = document.getElementById('color_' + colorId);
            checkbox.checked = !checkbox.checked;
            card.classList.toggle('selected', checkbox.checked);
        }

        $(document).ready(function() {
            // Category to Subcategory dependent dropdown
            $('#buy_category_id').on('change', function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('#buy_subcategory_id');

                // Clear subcategory dropdown
                subcategorySelect.html('<option value="">Select Subcategory</option>');

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('product.get-subcategories') }}",
                        type: "GET",
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                subcategorySelect.append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        },
                        error: function() {
                            console.log('Error fetching subcategories');
                        }
                    });
                }
            });

            // Toggle color extra fields
            $('.color-checkbox').on('change', function() {
                var id = $(this).data('id');
                if ($(this).is(':checked')) {
                    $('#color-fields-' + id).show();
                    $('#color-option-' + id).addClass('selected');
                } else {
                    $('#color-fields-' + id).hide();
                    $('#color-option-' + id).removeClass('selected');
                }
            });

            // Toggle storage extra fields
            $('.storage-checkbox').on('change', function() {
                var id = $(this).data('id');
                if ($(this).is(':checked')) {
                    $('#storage-fields-' + id).show();
                    $('#storage-option-' + id).addClass('selected');
                } else {
                    $('#storage-fields-' + id).hide();
                    $('#storage-option-' + id).removeClass('selected');
                }
            });

            // Gallery images preview with remove functionality
            let selectedFiles = [];

            $('#images').on('change', function(e) {
                const files = Array.from(e.target.files);
                selectedFiles = files;
                updateImagePreviews();
            });

            function updateImagePreviews() {
                const previewContainer = $('#new-images-preview');
                const previewWrapper = $('#new-images-preview-container');
                previewContainer.empty();

                if (selectedFiles.length === 0) {
                    previewWrapper.hide();
                    updateFileInput();
                    return;
                }

                previewWrapper.show();

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = $(`
                        <div class="new-image-preview" data-index="${index}">
                            <img src="${e.target.result}" alt="Preview">
                            <button type="button" class="remove-btn" data-index="${index}">&times;</button>
                        </div>
                    `);
                        previewContainer.append(preview);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Remove image from selection
            $(document).on('click', '.new-image-preview .remove-btn', function() {
                const index = $(this).data('index');
                selectedFiles.splice(index, 1);
                updateImagePreviews();
                updateFileInput();
            });

            function updateFileInput() {
                // Create a new DataTransfer to update the file input
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                document.getElementById('images').files = dt.files;
            }
        });
    </script>
@endpush
