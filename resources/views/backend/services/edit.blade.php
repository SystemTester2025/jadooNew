@extends('backend.layouts.app')

@section('title', 'Edit Service')
@section('header', 'Edit Service: ' . $service->title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Service Details</h5>
        <div>
            <a href="{{ route('service', $service->slug) }}" class="btn btn-info btn-sm" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> View on Site
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Services
            </a>
        </div>
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

        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $service->title) }}" required>
                <small class="text-muted">The title of the service. This will also generate the slug.</small>
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" value="{{ $service->slug }}" disabled>
                <small class="text-muted">The slug is automatically generated from the title and used in the URL.</small>
            </div>
            
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description', $service->short_description) }}</textarea>
                <small class="text-muted">A brief description of the service. This will be displayed in service listings.</small>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control summernote" id="content" name="content" rows="10">{{ old('content', $service->content) }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Image Path</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $service->image) }}">
                <small class="text-muted">The path to the service image. Example: images/services/service-name.jpg</small>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $service->order) }}">
                        <small class="text-muted">The order in which this service appears in listings.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $service->is_active) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $service->is_active) ? '' : 'selected' }}>Inactive</option>
                        </select>
                        <small class="text-muted">If inactive, the service will not be visible on the website.</small>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Service</button>
            </div>
        </form>
    </div>
</div>
@endsection 