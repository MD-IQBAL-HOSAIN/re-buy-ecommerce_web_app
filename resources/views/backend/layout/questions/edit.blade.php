@extends('backend.master')

@section('title', 'Dashboard | Edit Question')

@push('styles')
@endpush

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Question</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('question.index') }}">Questions</a></li>
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
                    <form action="{{ route('question.update', $data->id) }}" method="POST">
                        @csrf

                        {{-- Sell Product --}}
                        <div class="mb-3">
                            <label for="sell_product_id" class="form-label">Sell Product <span class="text-danger">*</span></label>
                            <select name="sell_product_id" id="sell_product_id" class="form-select">
                                <option value="">Select Product</option>
                                @foreach ($sellProducts as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('sell_product_id', $data->sell_product_id ?? '') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sell_product_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Question --}}
                        <div class="mb-3">
                            <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                            <textarea name="question" id="question" class="form-control" rows="3"
                                placeholder="Enter question">{{ old('question', $data->question) }}</textarea>
                            @error('question')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Price --}}
                       {{--  <div class="mb-3">
                            <label for="price" class="form-label">Question Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" class="form-control" step="0.01" min="0"
                                value="{{ old('price', $data->price) }}" placeholder="Enter price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        {{-- Options --}}
                        <div class="mb-3">
                            <label class="form-label">Options <span class="text-danger">*</span></label>
                            <div id="options-wrapper">
                                @forelse ($data->options as $option)
                                    <div class="row g-2 option-row mb-2">
                                        <div class="col-md-8">
                                            <input type="text" name="options_text[]" class="form-control"
                                                value="{{ $option->option }}" placeholder="Option text">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="options_price[]" class="form-control" step="0.01" min="0"
                                                value="{{ $option->price }}" placeholder="Price">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row g-2 option-row">
                                        <div class="col-md-8">
                                            <input type="text" name="options_text[]" class="form-control"
                                                placeholder="Option text">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="options_price[]" class="form-control" step="0.01" min="0"
                                                placeholder="Price">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            @error('options_text')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('options_text.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-option">+ Add Option</button>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('question.index') }}" class="btn btn-secondary">Back to List</a>
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
        $(document).on('click', '#add-option', function() {
            const row = `
                <div class="row g-2 option-row mt-2">
                    <div class="col-md-8">
                        <input type="text" name="options_text[]" class="form-control" placeholder="Option text">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="options_price[]" class="form-control" step="0.01" min="0" placeholder="Price">
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                    </div>
                </div>`;
            $('#options-wrapper').append(row);
        });

        $(document).on('click', '.remove-option', function() {
            if ($('.option-row').length > 1) {
                $(this).closest('.option-row').remove();
            }
        });
    </script>
@endpush
