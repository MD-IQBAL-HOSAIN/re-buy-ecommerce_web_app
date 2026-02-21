@extends('backend.master')

@section('title', 'Dashboard | Edit What would you Like To Sell Header')

@push('styles')
@endpush

@section('content')

    {{-- PAGE-HEADER for What would you Like To Sell start --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Header Of What would you Like To Sell</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">What would you Like To Sell Header</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER for What would you Like To Sell end --}}

    {{-- Header Update Form start --}}
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form action="{{ route('what-like-to-sell.update') }}" method="POST">
                        @csrf

                        {{-- Language --}}
                        <div class="mb-3">
                            <label for="language_id" class="form-label">Language</label>
                            <select name="language_id" id="language_id" class="form-control">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}"
                                        {{ old('language_id', $cms->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $cms->title ?? '') }}" placeholder="Enter title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Subtitle --}}
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control"
                                value="{{ old('subtitle', $cms->subtitle ?? '') }}" placeholder="Enter subtitle">
                            @error('subtitle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Header Update Form end --}}

@endsection

@push('scripts')
@endpush
