@extends('backend.master')

@section('title', 'Language Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1 class="page-title">Edit Language</h1>
        </div>
        <div class="ms-auto d-flex align-items-center gap-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Language</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form action="{{ route('language.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="code" class="form-label">Language Code</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ old('code', $data->code) }}" placeholder="Language Code">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Language Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Language Name" value="{{ old('name', $data->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
