@extends('backend.master')

@section('title', 'Dashboard | Edit Banner')

@push('styles')
    <style>
        .video-preview {
            width: 100%;
            height: 240px;
            background: #f5f5f5;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            display: block;
            object-fit: contain;
        }
    </style>
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Banner</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Banner</li>
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
                    <form action="{{ route('banner.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Language --}}
                            <div class="col-12 mb-3">
                                <label for="language_id" class="form-label">Language</label>
                                <select name="language_id" id="language_id" class="form-select">
                                    <option value="">Select Language</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            {{ old('language_id', $banner->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Image --}}
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Buy Part Banner Image</label>
                                <input type="file" name="image" id="image" class="form-control dropify"
                                    accept="image/*" data-default-file="{{ asset($banner->image) }}">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Image Two --}}
                            <div class="col-md-6 mb-3">
                                <label for="image_two" class="form-label">Sell Part Banner Image</label>
                                <input type="file" name="image_two" id="image_two" class="form-control dropify"
                                    accept="image/*" data-default-file="{{ asset($banner->image_two) }}">
                                @error('image_two')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- video for Mobile --}}
                            <div class="col-md-6 mb-3">
                                <label for="video_mobile" class="form-label">CMS Video (Mobile)</label>
                                <input type="file" name="video_mobile" id="video_mobile" class="form-control dropify"
                                    accept="video/*" data-default-file="{{ asset($banner->image_four) }}">
                                @error('video_mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <video id="video_mobile_preview" class="video-preview mt-2" controls preload="metadata"
                                    @if (!empty($banner->image_four)) src="{{ asset($banner->image_four) }}" @endif>
                                </video>
                            </div>

                            {{-- video for desktop --}}
                            <div class="col-md-6 mb-3">
                                <label for="video_desktop" class="form-label">CMS Video (Desktop)</label>
                                <input type="file" name="video_desktop" id="video_desktop" class="form-control dropify"
                                    accept="video/*" data-default-file="{{ asset($banner->image_five) }}">
                                @error('video_desktop')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <video id="video_desktop_preview" class="video-preview mt-2" controls preload="metadata"
                                    @if (!empty($banner->image_five)) src="{{ asset($banner->image_five) }}" @endif>
                                </video>
                            </div>
                        </div>
                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Banner</button>
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
        function bindVideoPreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input || !preview) return;

            input.addEventListener('change', () => {
                const file = input.files && input.files[0];
                if (!file) return;
                const url = URL.createObjectURL(file);
                preview.src = url;
            });
        }

        bindVideoPreview('video_mobile', 'video_mobile_preview');
        bindVideoPreview('video_desktop', 'video_desktop_preview');
    </script>
@endpush
