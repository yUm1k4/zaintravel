@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Travel Package</h1>
            <a href="{{ route('travel-package.index') }}" class="btn btn-sm btn-success shadow-sm">
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
                <form action="{{ route('travel-package.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title travel package" value="{{ old('title') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" name="location" placeholder="Location name" value="{{ old('location') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="about">About</label>
                            <textarea name="about" id="about" cols="30" rows="10" class="d-block w-100 form-control" placeholder="About travel package">{{ old('about') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="featured_event">Featured Event</label>
                            <input type="text" class="form-control" name="featured_event" placeholder="Event name" value="{{ old('featured_event') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="language">Language</label>
                            <input type="text" class="form-control" name="language" placeholder="Language" value="{{ old('language') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="food">Food</label>
                            <input type="text" class="form-control" name="food" placeholder="Food" value="{{ old('food') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="departure_date">Departure Date</label>
                            <input type="date" class="form-control" name="departure_date" placeholder="Departure Date" value="{{ old('departure_date') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control" name="duration" placeholder="Duration" value="{{ old('duration') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" name="type" placeholder="Type" value="{{ old('type') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="price">Number</label>
                            <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}">
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