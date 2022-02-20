@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
            {{-- <a href="{{ route('transaction.create') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm"> Add New</i>
            </a> --}}
        </div>

        <!-- Content -->
        <div class="row">
            <div class="card-body">
                <div class="table responsive">
                    <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="text-center">ID</td>
                                <td>Travel</td>
                                <td>User</td>
                                <td>Visa</td>
                                <td>Total</td>
                                <td>Status</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $item->id }}</td>
                                    <td>{{ $item->travel_package->title }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>${{ $item->additional_visa }}</td>
                                    <td>${{ $item->transaction_total }}</td>
                                    <td>{{ $item->transaction_status }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('transaction.show', $item->id) }}" class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transaction.edit', $item->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('transaction.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data Empty</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection