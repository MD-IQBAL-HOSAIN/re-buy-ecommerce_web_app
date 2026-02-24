@extends('backend.master')

@section('title', 'Dashboard | Create Sell Product')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Create Sell Product</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sell-products.index') }}">Sell Products</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form action="{{ route('sell-products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Language --}}
                        <div class="mb-3">
                            <label for="language_id" class="form-label">Language <span class="text-danger">*</span></label>
                            <select name="language_id" id="language_id" class="form-select">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}"
                                        {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Category --}}
                            <div class="col-md-6 mb-3">
                                <label for="buy_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="buy_category_id" id="buy_category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('buy_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('buy_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Subcategory --}}
                            <div class="col-md-6 mb-3">
                                <label for="buy_subcategory_id" class="form-label">Subcategory <span
                                        class="text-danger">*</span></label>
                                <select name="buy_subcategory_id" id="buy_subcategory_id" class="form-select"
                                    data-selected="{{ old('buy_subcategory_id') }}">
                                    <option value="">Select Subcategory</option>
                                </select>
                                @error('buy_subcategory_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" placeholder="Enter product name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Short Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="short_name" class="form-label">Short Name</label>
                                <input type="text" name="short_name" id="short_name" class="form-control"
                                    value="{{ old('short_name') }}" placeholder="Enter short name">
                                @error('short_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="storage" class="form-label">Storage</label>
                                <select name="storage" id="storage" class="form-select">
                                    <option value="">Select Storage</option>
                                    @php
                                        $storageOptions = ['32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB'];
                                    @endphp
                                    @foreach ($storageOptions as $option)
                                        <option value="{{ $option }}" {{ old('storage') == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('storage')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" name="color" id="color" class="form-control"
                                    value="{{ old('color') }}" placeholder="Enter color">
                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" id="model" class="form-control"
                                    value="{{ old('model') }}" placeholder="Enter model">
                                @error('model')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ean" class="form-label">EAN</label>
                                <input type="text" name="ean" id="ean" class="form-control"
                                    value="{{ old('ean') }}" placeholder="Enter EAN">
                                @error('ean')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        {{--  <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control ck-editor" rows="5"
                                placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="dropify form-control"
                                accept="image/*">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('sell-products.index') }}" class="btn btn-secondary">Back to List</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('buy_category_id');
            const subcategorySelect = document.getElementById('buy_subcategory_id');
            const selectedSubcategory = subcategorySelect.dataset.selected || '';

            const renderOptions = (items, selectedId) => {
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                items.forEach((item) => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    if (String(item.id) === String(selectedId)) {
                        option.selected = true;
                    }
                    subcategorySelect.appendChild(option);
                });
            };

            const loadSubcategories = (categoryId, selectedId = '') => {
                if (!categoryId) {
                    renderOptions([], '');
                    return;
                }

                fetch(`{{ route('sell-products.get-subcategories') }}?category_id=${categoryId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then((response) => response.json())
                    .then((data) => renderOptions(data, selectedId))
                    .catch(() => renderOptions([], ''));
            };

            categorySelect.addEventListener('change', function() {
                loadSubcategories(this.value, '');
            });

            if (categorySelect.value) {
                loadSubcategories(categorySelect.value, selectedSubcategory);
            }
        });
    </script>
@endpush
