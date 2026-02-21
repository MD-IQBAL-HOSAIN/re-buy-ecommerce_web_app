@extends('backend.master')

@section('title', 'Product Details')

@push('styles')
    <style>
        .color-box {
            width: 25px;
            height: 25px;
            display: inline-block;
            border-radius: 4px;
            border: 1px solid #ddd;
            vertical-align: middle;
            margin-right: 5px;
        }

        .badge-item {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 12px;
            border-radius: 20px;
            margin: 3px;
            font-size: 13px;
        }

        .gallery-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin: 5px;
            cursor: pointer;
            transition: transform 0.2s, border 0.2s;
            border: 2px solid transparent;
        }

        .gallery-image:hover {
            transform: scale(1.05);
            border: 2px solid #007bff;
        }

        .gallery-image.active {
            border: 2px solid #28a745;
        }

        .main-product-image {
            transition: opacity 0.3s;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Product Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <div class="row">
                        {{-- Product Image --}}
                        <div class="col-md-4 text-center mb-4">
                            @php
                                $mainThumbnail = $data->thumbnail
                                    ? (\Illuminate\Support\Str::startsWith($data->thumbnail, ['http://', 'https://'])
                                        ? $data->thumbnail
                                        : asset($data->thumbnail))
                                    : asset('frontend/no-image.jpg');
                            @endphp
                            <img src="{{ $mainThumbnail }}" id="main-product-image"
                                class="img-fluid rounded main-product-image" style="max-height: 300px;"
                                alt="{{ $data->thumbnail ? 'Product Image' : 'No Image' }}">

                            @if ($data->images && $data->images->count() > 0)
                                <div class="mt-3">
                                    <h6>Gallery Images <small class="text-muted">(Click to preview)</small></h6>
                                    @foreach ($data->images as $image)
                                        @php
                                            $gallerySrc = $image->image
                                                ? (\Illuminate\Support\Str::startsWith($image->image, ['http://', 'https://'])
                                                    ? $image->image
                                                    : asset($image->image))
                                                : asset('frontend/no-image.jpg');
                                        @endphp
                                        <img src="{{ $gallerySrc }}" class="gallery-image gallery-thumb"
                                            data-full="{{ $gallerySrc }}" alt="Gallery">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="col-md-8">
                            <h3>{{ $data->name ?? 'N/A' }}</h3>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Category</th>
                                        <td>{{ $data->buySubcategory?->buyCategory?->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subcategory</th>
                                        <td>{{ $data->buySubcategory?->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Condition</th>
                                        <td>{{ $data->condition?->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Storage</th>
                                        <td>
                                            @if ($data->storages && $data->storages->count() > 0)
                                                @php $storage = $data->storages->first(); @endphp
                                                {{ (int) $storage->capacity }} {{ $storage->name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>
                                            <strong>€{{ number_format($data->price ?? 0, 2) }}</strong>
                                            @if ($data->discount_price)
                                                <del
                                                    class="text-muted ms-2">€{{ number_format($data->discount_price, 2) }}</del>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount Price</th>
                                        <td>
                                            <strong>€{{ number_format($data->discount_price ?? 0, 2) }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Old Price</th>
                                        <td>
                                            <strong>€{{ number_format($data->old_price ?? 0, 2) }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Stock</th>
                                        <td>{{ $data->stock ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($data->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Featured</th>
                                        <td>
                                            @if ($data->is_featured)
                                                <span class="badge bg-primary">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{!! $data->description ?? 'N/A' !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td> {{ $data->created_at ? $data->created_at->format('d M, Y h:i A') : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td> {{ $data->updated_at ? $data->updated_at->format('d M, Y h:i A') : 'N/A' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    {{-- Colors --}}
                    <div class="mb-4">
                        <h5>Available Colors</h5>
                        @if ($data->colors && $data->colors->count() > 0)
                            <div>
                                @foreach ($data->colors as $color)
                                    <span class="badge-item">
                                        <span class="color-box"
                                            style="background-color: {{ $color->code ?? '#ccc' }}"></span>
                                        {{ $color->name ?? 'Unknown' }}
                                        @if (($color->pivot->extra_price ?? 0) > 0)
                                            (+€{{ number_format($color->pivot->extra_price, 2) }})
                                        @endif
                                        <small class="text-muted">(Stock: {{ $color->pivot->stock ?? 0 }})</small>
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No colors assigned</p>
                        @endif
                    </div>

                    {{-- Protection Services --}}
                    <div class="mb-4">
                        <h5>Protection Services</h5>
                        @if ($data->protectionServices && $data->protectionServices->count() > 0)
                            <div>
                                @foreach ($data->protectionServices as $service)
                                    <span class="badge-item">
                                        {{ $service->name ?? 'Unknown' }} - €{{ number_format($service->price ?? 0, 2) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No protection services assigned</p>
                        @endif
                    </div>

                    {{-- Accessories --}}
                    <div class="mb-4">
                        <h5>Accessories</h5>
                        @if ($data->accessories && $data->accessories->count() > 0)
                            <div>
                                @foreach ($data->accessories as $accessory)
                                    <span class="badge-item">
                                        {{ $accessory->name ?? 'Unknown' }} -
                                        €{{ number_format($accessory->price ?? 0, 2) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No accessories assigned</p>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('product.edit', $data->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Click on gallery image to show in main view
            $('.gallery-thumb').on('click', function() {
                var fullImage = $(this).data('full');

                // Remove active class from all gallery images
                $('.gallery-thumb').removeClass('active');

                // Add active class to clicked image
                $(this).addClass('active');

                // Fade out, change src, fade in
                $('#main-product-image').fadeOut(150, function() {
                    $(this).attr('src', fullImage).fadeIn(150);
                });
            });
        });
    </script>
@endpush
