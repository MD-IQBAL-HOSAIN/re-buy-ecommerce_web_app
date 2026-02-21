@extends('backend.master')

@section('title', 'Dashboard | Edit Storage')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Storage</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('storage.index') }}">Storages</a></li>
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
                    <form action="{{ route('storage.update', $storage->id) }}" method="POST">
                        @csrf

                        {{-- Language --}}
                        <div class="mb-3">
                            <label for="language_id" class="form-label">Language</label>
                            <select name="language_id" id="language_id" class="form-select">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" {{ old('language_id', $storage->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Storage Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Storage Name <span class="text-danger">*</span></label>
                            <select name="name" id="name" class="form-control">
                                <option value="GB" {{ old('name', $storage->name) == 'GB' ? 'selected' : '' }}>GB</option>
                                <option value="TB" {{ old('name', $storage->name) == 'TB' ? 'selected' : '' }}>TB</option>
                                <option value="PB" {{ old('name', $storage->name) == 'PB' ? 'selected' : '' }}>PB</option>
                            </select>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Capacity --}}
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                            <input type="number" name="capacity" id="capacity" class="form-control"
                                value="{{ old('capacity', $storage->capacity) }}" placeholder="Enter storage capacity">
                            @error('capacity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('storage.index') }}" class="btn btn-secondary">Back to List</a>
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
