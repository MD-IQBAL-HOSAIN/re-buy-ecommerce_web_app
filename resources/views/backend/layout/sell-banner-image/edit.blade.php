@extends('backend.master')

@section('title', 'Dashboard | Edit Sell Banner Image')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Sell Banner Image</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sell-banner-image.index') }}">Sell Banner Images</a></li>
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
                    <form action="{{ route('sell-banner-image.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-2 text-muted">
                            Upload a new image only if you want to replace the existing one.
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Banner Image (optional)</label>
                            <input type="file" name="image" id="image" class="form-control dropify"
                                accept="image/*" data-default-file="{{ $data->image ? asset($data->image) : '' }}">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('sell-banner-image.index') }}" class="btn btn-secondary">Back to List</a>
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
