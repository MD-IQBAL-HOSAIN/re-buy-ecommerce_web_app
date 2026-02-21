@extends('backend.master')

@section('title', 'Question Answer Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Question Answer Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('question-answers.index') }}">Question Answers</a></li>
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
                    <h4 class="text-center mb-4">Question Answer Details</h4>

                    <table class="table table-bordered mb-4">
                        <tbody>
                            <tr>
                                <th style="width: 220px;">User</th>
                                <td>{{ $data->user->name ?? 'N/A' }} ({{ $data->user->email ?? 'N/A' }})</td>
                            </tr>
                            <tr>
                                <th>Sell Product</th>
                                <td>{{ $data->sellProduct->name ?? 'N/A' }}</td>
                            </tr>
                           {{--  <tr>
                                <th>Question Price</th>
                                <td>{{ number_format($data->question_price, 2) }}</td>
                            </tr> --}}
                            <tr>
                                <th>Option Price</th>
                                <td>{{ number_format($data->option_price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mb-3">User Info</h5>
                    <table class="table table-bordered mb-4">
                        <tbody>
                            <tr>
                                <th style="width: 220px;">Name</th>
                                <td>{{ $data->user_info['name'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $data->user_info['address'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $data->user_info['city'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Zipcode</th>
                                <td>{{ $data->user_info['zipcode'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $data->user_info['country'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $data->user_info['phone'] ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mb-3">Answers</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    {{-- <th>Question Price</th> --}}
                                    <th>Selected Option</th>
                                    <th>Option Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($answerDetails as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item['question'] }}</td>
                                        {{-- <td>{{ number_format($item['question_price'], 2) }}</td> --}}
                                        <td>{{ $item['option'] }}</td>
                                        <td>{{ number_format($item['option_price'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No answers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('question-answers.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
