@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Transaction {{ $item->user->name }}</h1>
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
                <form action="{{ route('transaction.update', $item->id) }}" method="POST">
                    @method('PUT')
                    @csrf
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
                            <select name="transaction_status" required class="form-control">
                                <option value="{{ $item->transaction_status }}">{{ $item->transaction_status }}</option>
                                <option value="IN_CART">In Cart</option>
                                <option value="PENDING">Pending</option>
                                <option value="SUCCESS">Success</option>
                                <option value="CANCEL">Cancel</option>
                                <option value="FAILED">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success btn-block" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection