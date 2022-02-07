@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Gallery</h1>
            <a href="{{ route('gallery.index') }}" class="btn btn-sm btn-success shadow-sm">
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
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="travel_packages_id">Travel Package</label>
                            <select name="travel_packages_id" required class="form-control">
                                <option value="">Select Package Travel Name</option>
                                @foreach ($travel_packages as $travel_package)
                                    <option value="{{ $travel_package->id }}">{{ $travel_package->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success btn-block" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection