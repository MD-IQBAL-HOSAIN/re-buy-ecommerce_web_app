@extends('backend.master')

@section('title', 'Dashboard | Edit Protection Service')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Protection Service</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('protection-service.index') }}">Protection Services</a></li>
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
                    <form action="{{ route('protection-service.update', $data->id) }}" method="POST">
                        @csrf

                        {{-- Language --}}
                        <div class="mb-3">
                            <label for="language_id" class="form-label">Language</label>
                            <select name="language_id" id="language_id" class="form-select">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" {{ old('language_id', $data->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Service Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $data->name) }}" placeholder="Enter service name (e.g., Express Shipping, Extended Warranty)">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Enter description (e.g., Delivery within 24 hours)">{{ old('description', $data->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (€) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" class="form-control" step="0.01" min="0"
                                value="{{ old('price', $data->price) }}" placeholder="Enter price (e.g., 9.99)">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('protection-service.index') }}" class="btn btn-secondary">Back to List</a>
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
