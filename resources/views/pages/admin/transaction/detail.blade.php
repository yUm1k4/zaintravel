@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Transaction {{ $item->user->name }}</h1>
            <a href="{{ route('transaction.index') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-arrow-left fa-sm"> Back to list</i>
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Content -->
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>ID Travel Package</label>
                        <input type="text" readonly disabled class="form-control"  value="{{ $item->id }}">
                    </div>
                    <div class="col-md-6">
                        <label>Travel Package Title</label>
                        <input type="text" readonly disabled class="form-control"  value="{{ $item->travel_package->title }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Buyer / Purchaser</label>
                        <input type="text" readonly disabled class="form-control"  value="{{ $item->user->name }}">
                    </div>
                    <div class="col-md-6">
                        <label>Additional Visa</label>
                        <input type="text" readonly disabled class="form-control" value="${{ $item->additional_visa }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Total Transaction</label>
                        <input type="text" readonly disabled class="form-control"  value="${{ $item->transaction_total }}">
                    </div>
                    <div class="col-md-6">
                        <label>Transaction Status</label>
                        <input type="text" readonly disabled class="form-control" value="{{ $item->transaction_status }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>User Join</label>
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Nationality</th>
                                <th class="text-center">Visa</th>
                                <th class="text-center">DOE Passport</th>
                            </tr>
                            @foreach ($item->details as $detail)
                                <tr>
                                    <td class="text-center">{{ $detail->id }}</td>
                                    <td>{{ $detail->username }}</td>
                                    <td>{{ $detail->nationality }}</td>
                                    <td>{{ $detail->is_visa ? '30 Days' : 'N/A' }}</td>
                                    <td>{{ $detail->doe_passport }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection