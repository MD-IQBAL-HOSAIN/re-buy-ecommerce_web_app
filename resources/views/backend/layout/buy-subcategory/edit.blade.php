@extends('backend.master')

@section('title', 'Dashboard | Edit Buy Subcategory')

@push('styles')
    <style>
        .featured-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 16px;
            border: 2px solid #f6a800;
            border-radius: 12px;
            background: #fffaf0;
            max-width: 320px;
        }

        .featured-toggle__left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #b87800;
            font-weight: 600;
        }

        .featured-toggle__icon {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffe39a;
            border-radius: 6px;
            font-size: 14px;
        }

        .featured-toggle__switch {
            position: relative;
            width: 52px;
            height: 28px;
        }

        .featured-toggle__switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .featured-toggle__slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #e5e7eb;
            transition: 0.3s;
            border-radius: 999px;
            box-shadow: inset 0 0 0 1px #d1d5db;
        }

        .featured-toggle__slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            top: 3px;
            background: #ffffff;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .featured-toggle__switch input:checked + .featured-toggle__slider {
            background: #f6a800;
        }

        .featured-toggle__switch input:checked + .featured-toggle__slider:before {
            transform: translateX(24px);
        }
    </style>
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Buy Subcategory</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Buy Subcategory</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                    <form action="{{ route('buy-subcategory.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="buy_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="buy_category_id" id="buy_category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('buy_category_id', $data->buy_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('buy_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $data->name) }}" placeholder="Enter subcategory name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control dropify" type="file" name="image"
                                @isset($data->image)
                                                data-default-file="{{ asset($data->image) }}"
                                    @endisset>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Featured --}}
                        <div class="mb-3">
                            <label class="form-label d-block text-muted mb-2">
                                # If you want to make this subcategory featured then check the box.
                            </label>
                            <div class="featured-toggle">
                                <div class="featured-toggle__left">
                                    <span class="featured-toggle__icon">*</span>
                                    <span>Feature Subcategory</span>
                                </div>
                                <label class="featured-toggle__switch" for="is_featured">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                                        value="1" {{ old('is_featured', $data->is_featured) ? 'checked' : '' }}>
                                    <span class="featured-toggle__slider"></span>
                                </label>
                            </div>
                            @error('is_featured')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('buy-subcategory.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@push('scripts')
@endpush

