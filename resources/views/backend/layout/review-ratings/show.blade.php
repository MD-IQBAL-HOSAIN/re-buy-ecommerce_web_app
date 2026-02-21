@extends('backend.master')

@section('title', 'Dashboard | Review Details')

@push('styles')
@endpush

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Review Details</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('review-ratings.index') }}">Reviews & Ratings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Review Information</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">User Name</th>
                                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>User Email</th>
                                    <td>{{ $review->user->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                    <td>{{ $review->product->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Language</th>
                                    <td>{{ $review->language->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Rating</th>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="mdi mdi-star text-warning"></i>
                                            @else
                                                <i class="mdi mdi-star-outline text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-2">({{ $review->rating }}/5)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($review->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review Text</th>
                                    <td>{{ $review->review_text ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $review->created_at ? $review->created_at->format('d M, Y h:i A') : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('review-ratings.index') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
