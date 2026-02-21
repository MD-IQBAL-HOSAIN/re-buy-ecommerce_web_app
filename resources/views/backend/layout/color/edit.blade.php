@extends('backend.master')

@section('title', 'Dashboard | Edit Color')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Color</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('color.index') }}">Colors</a></li>
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
                    <form action="{{ route('color.update', $data->id) }}" method="POST">
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

                        {{-- Color Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Color Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $data->name) }}" placeholder="Enter color name (e.g., Red, Blue)">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Color Code --}}
                        <div class="mb-3">
                            <label for="code" class="form-label">Color Code (Hex)</label>
                            <div class="input-group">
                                <input type="color" name="color_picker" id="color_picker" class="form-control form-control-color"
                                    value="{{ old('code', $data->code ?? '#000000') }}" title="Choose color" style="width: 60px;">
                                <input type="text" name="code" id="code" class="form-control"
                                    value="{{ old('code', $data->code) }}" placeholder="#FF0000">
                            </div>
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('color.index') }}" class="btn btn-secondary">Back to List</a>
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
        $(document).ready(function() {
            // Sync color picker with text input
            $('#color_picker').on('input', function() {
                $('#code').val($(this).val());
            });

            $('#code').on('input', function() {
                var colorValue = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(colorValue)) {
                    $('#color_picker').val(colorValue);
                }
            });
        });
    </script>
@endpush
