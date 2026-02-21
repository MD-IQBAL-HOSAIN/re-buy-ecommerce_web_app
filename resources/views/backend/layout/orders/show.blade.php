@extends('backend.master')

@section('title', 'Order Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Orders</a></li>
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
                    <h1 class="text-center">Order Details</h1>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Order Number</th>
                                <td>{{ $data->order_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $data->user->name ?? 'N/A' }}</td>
                            </tr>
                           {{--  <tr>
                                <th>Delivery Fee</th>
                                <td>€{{ number_format($data->delivery_fee, 2) }}</td>
                            </tr> --}}
                            <tr>
                                <th>Total Amount</th>
                                <td>€ {{ number_format($data->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td>{{ ucfirst($data->payment_status ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($data->status ?? 'N/A') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @if(isset($customerInfo) && $customerInfo)
                        <h3>Customer Information</h3>
                        <table class="table table-bordered">
                            <tbody>
                               {{--  <tr>
                                    <th>ID</th>
                                    <td>{{ $customerInfo->id ?? 'N/A' }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $customerInfo->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $customerInfo->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $customerInfo->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $customerInfo->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $customerInfo->country ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $customerInfo->city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ $customerInfo->state ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Postal Code</th>
                                    <td>{{ $customerInfo->postal_code ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                        </tbody>
                    </table>

                    <h3>Order Items</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Thumbnail</th>
                                <th>Product</th>
                                <th>Color</th>
                                <th>Storage</th>
                                <th>Accessory</th>
                                <th>Accessory Price</th>
                                <th>Protection Services</th>
                                <th>Protection Price</th>
                                <th>Product Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->orderDetails as $detail)
                            <tr>
                                <td>
                                    @if($detail->product->thumbnail)
                                        <img src="{{ asset($detail->product->thumbnail) }}" alt="Thumbnail" width="80" height="auto" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('frontend/no-image.jpg') }}" alt="Thumbnail" width="80" height="auto" class="img-thumbnail">
                                    @endif
                                </td>
                                <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                <td>{{ $detail->color->name ?? 'N/A' }}</td>
                                <td>{{ number_format($detail->storage->capacity ?? 'N/A', 0, '.', '') }} {{ $detail->storage->name ?? 'N/A' }}</td>
                                <td>{{ $detail->accessory->name ?? 'N/A' }}</td>
                                <td>€ {{ number_format($detail->accessory_price, 2) }}</td>
                                <td>
                                    @if($detail->protection_services)
                                        @foreach($detail->protection_services as $i => $ps)
                                            {{ $i + 1 }}. {{ \App\Models\ProtectionService::find($ps)->name ?? 'N/A' }} - €{{ number_format(\App\Models\ProtectionService::find($ps)->price, 2) }}<br>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>€ {{ number_format($detail->protection_services_price, 2) }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>€ {{ number_format($detail->unit_price, 2) }}</td>
                                <td>€ {{ number_format($detail->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('order.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
