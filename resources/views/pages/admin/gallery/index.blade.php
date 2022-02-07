@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gallery</h1>
            <a href="{{ route('gallery.create') }}" class="btn btn-sm btn-success shadow-sm">
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
                                <td>Travel</td>
                                <td>Image</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $item->id }}</td>
                                    {{-- travel_package->title dari relasi Controller --}}
                                    <td>{{ $item->travel_package->title }}</td>
                                    <td>
                                        {{-- karena pake Storage jangan lupa jalanin di terminal php artisan storage:link --}}
                                        <img src="{{ Storage::url($item->image) }}" width="150px" class="img-thumbnail">
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('gallery.edit', $item->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('gallery.destroy', $item->id) }}" method="POST" class="d-inline">
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
                                    <td colspan="4" class="text-center">Data Empty</td>
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