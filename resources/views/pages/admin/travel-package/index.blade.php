@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Travel Package</h1>
            <a href="{{ route('travel-package.create') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm"> Add New</i>
            </a>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="card-body">
                <div class="table responsive">
                    <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="text-center">ID</td>
                                <td>Title</td>
                                <td>Location</td>
                                <td>Type</td>
                                <td>Departure Date</td>
                                <td>Type</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->departure_date }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('travel-package.edit', $item->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('travel-package.destroy', $item->id) }}" method="POST" class="d-inline">
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