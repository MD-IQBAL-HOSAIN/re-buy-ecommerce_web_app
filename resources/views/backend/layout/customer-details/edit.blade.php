@extends('backend.master')

@section('title', 'Dashboard | Edit Customer Details')

@push('styles')
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Edit Customer Details</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Customer Details</li>
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
                    <form action="{{ route('customer-details.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Language --}}
                            <div class="col-12 mb-3">
                                <label for="language_id" class="form-label">Language</label>
                                <select name="language_id" id="language_id" class="form-select">
                                    <option value="">Select Language</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            {{ old('language_id', $customerDetails->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Customer Details --}}
                            <div class="col-md-6 mb-3">
                                <label for="customer_details" class="form-label">Customer Details Text</label>
                                <input type="text" name="customer_details" id="customer_details" class="form-control"
                                    value="{{ old('customer_details', $customerDetails->customer_details ?? '') }}" placeholder="Enter customer details text">
                                @error('customer_details')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email Text --}}
                            <div class="col-md-6 mb-3">
                                <label for="email_text" class="form-label">Email Text</label>
                                <input type="text" name="email_text" id="email_text" class="form-control"
                                    value="{{ old('email_text', $customerDetails->email_text ?? '') }}" placeholder="Enter email text">
                                @error('email_text')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name Text</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $customerDetails->name ?? '') }}" placeholder="Enter name text">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Text</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone', $customerDetails->phone ?? '') }}" placeholder="Enter phone text">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Continue --}}
                            <div class="col-md-6 mb-3">
                                <label for="continue" class="form-label">Continue Text</label>
                                <input type="text" name="continue" id="continue" class="form-control"
                                    value="{{ old('continue', $customerDetails->continue ?? '') }}" placeholder="Enter continue text">
                                @error('continue')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Order Summary --}}
                            <div class="col-md-6 mb-3">
                                <label for="order_summary" class="form-label">Order Summary Text</label>
                                <input type="text" name="order_summary" id="order_summary" class="form-control"
                                    value="{{ old('order_summary', $customerDetails->order_summary ?? '') }}" placeholder="Enter order summary text">
                                @error('order_summary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Total --}}
                            <div class="col-md-6 mb-3">
                                <label for="total" class="form-label">Total Text</label>
                                <input type="text" name="total" id="total" class="form-control"
                                    value="{{ old('total', $customerDetails->total ?? '') }}" placeholder="Enter total text">
                                @error('total')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Subtotal --}}
                            <div class="col-md-6 mb-3">
                                <label for="subtotal" class="form-label">Subtotal Text</label>
                                <input type="text" name="subtotal" id="subtotal" class="form-control"
                                    value="{{ old('subtotal', $customerDetails->subtotal ?? '') }}" placeholder="Enter subtotal text">
                                @error('subtotal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Shipping --}}
                            <div class="col-md-6 mb-3">
                                <label for="shipping" class="form-label">Shipping Text</label>
                                <input type="text" name="shipping" id="shipping" class="form-control"
                                    value="{{ old('shipping', $customerDetails->shipping ?? '') }}" placeholder="Enter shipping text">
                                @error('shipping')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Payment --}}
                            <div class="col-md-6 mb-3">
                                <label for="payment" class="form-label">Payment Text</label>
                                <input type="text" name="payment" id="payment" class="form-control"
                                    value="{{ old('payment', $customerDetails->payment ?? '') }}" placeholder="Enter payment text">
                                @error('payment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Review --}}
                            <div class="col-md-6 mb-3">
                                <label for="review" class="form-label">Review Text</label>
                                <input type="text" name="review" id="review" class="form-control"
                                    value="{{ old('review', $customerDetails->review ?? '') }}" placeholder="Enter review text">
                                @error('review')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Back --}}
                            <div class="col-md-6 mb-3">
                                <label for="back" class="form-label">Back Text</label>
                                <input type="text" name="back" id="back" class="form-control"
                                    value="{{ old('back', $customerDetails->back ?? '') }}" placeholder="Enter back text">
                                @error('back')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Products --}}
                            <div class="col-md-6 mb-3">
                                <label for="products" class="form-label">Products Text</label>
                                <input type="text" name="products" id="products" class="form-control"
                                    value="{{ old('products', $customerDetails->products ?? '') }}" placeholder="Enter products text">
                                @error('products')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact Text</label>
                                <input type="text" name="contact" id="contact" class="form-control"
                                    value="{{ old('contact', $customerDetails->contact ?? '') }}" placeholder="Enter contact text">
                                @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City Text</label>
                                <input type="text" name="city" id="city" class="form-control"
                                    value="{{ old('city', $customerDetails->city ?? '') }}" placeholder="Enter city text">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Postal Code --}}
                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Postal Code Text</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control"
                                    value="{{ old('postal_code', $customerDetails->postal_code ?? '') }}" placeholder="Enter postal code text">
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Country --}}
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country Text</label>
                                <input type="text" name="country" id="country" class="form-control"
                                    value="{{ old('country', $customerDetails->country ?? '') }}" placeholder="Enter country text">
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="place_order" class="form-label">Place Order Text</label>
                                <input type="text" name="place_order" id="place_order" class="form-control"
                                    value="{{ old('place_order', $customerDetails->place_order ?? '') }}" placeholder="Enter place order text">
                                @error('place_order')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Customer Details</button>
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
