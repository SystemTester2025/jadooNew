@extends('backend.layouts.app')

@section('title', 'Create Service')
@section('header', 'Create New Service')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Service Details</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                <small class="text-muted">The title of the service. This will also generate the slug.</small>
            </div>
            
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
                <small class="text-muted">A brief description of the service. This will be displayed in service listings.</small>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control summernote" id="content" name="content" rows="10">{{ old('content') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Image Path</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ old('image') }}">
                <small class="text-muted">The path to the service image. Example: images/services/service-name.jpg</small>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order') }}">
                        <small class="text-muted">The order in which this service appears in listings.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', 1) ? '' : 'selected' }}>Inactive</option>
                        </select>
                        <small class="text-muted">If inactive, the service will not be visible on the website.</small>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Service</button>
            </div>
        </form>
    </div>
</div>
@endsection 