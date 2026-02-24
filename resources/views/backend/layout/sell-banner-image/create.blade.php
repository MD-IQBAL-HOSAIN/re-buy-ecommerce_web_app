@extends('backend.master')

@section('title', 'Dashboard | Add Sell Banner Images')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Add Sell Banner Images</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sell-banner-image.index') }}">Sell Banner Images</a></li>
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
                    <form action="{{ route('sell-banner-image.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-2 text-muted">
                            You can upload up to 4 images. The first image is required; the other 3 are optional.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="image_one" class="form-label">Banner Image 1 <span class="text-danger">*</span></label>
                                <input type="file" name="image_one" id="image_one" class="form-control dropify" accept="image/*">
                                @error('image_one')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image_two" class="form-label">Banner Image 2</label>
                                <input type="file" name="image_two" id="image_two" class="form-control dropify" accept="image/*">
                                @error('image_two')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image_three" class="form-label">Banner Image 3</label>
                                <input type="file" name="image_three" id="image_three" class="form-control dropify" accept="image/*">
                                @error('image_three')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image_four" class="form-label">Banner Image 4</label>
                                <input type="file" name="image_four" id="image_four" class="form-control dropify" accept="image/*">
                                @error('image_four')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Create</button>
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
