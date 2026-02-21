@extends('backend.master')

@section('title', 'Dashboard | Edit Feature Device Header')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Feature Device Header</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Feature Device Header</li>
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
                    <form action="{{ route('feature-device-header.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Language --}}
                            <div class="col-12 mb-3">
                                <label for="language_id" class="form-label">Language</label>
                                <select name="language_id" id="language_id" class="form-select">
                                    <option value="">Select Language</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            {{ old('language_id', $featureDevice->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Title --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title', $featureDevice->title ?? '') }}" placeholder="Enter title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Subtitle --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="subtitle" class="form-label">Subtitle</label>
                                <input type="text" name="subtitle" id="subtitle" class="form-control"
                                    value="{{ old('subtitle', $featureDevice->subtitle ?? '') }}"
                                    placeholder="Enter subtitle">
                                @error('subtitle')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Feature Device Header</button>
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
