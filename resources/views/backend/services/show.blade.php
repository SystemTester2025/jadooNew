@extends('backend.layouts.app')

@section('title', 'View Service')
@section('header', 'View Service: ' . $service->title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Service Details</h5>
        <div>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('service', $service->slug) }}" class="btn btn-info" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> View on Site
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Basic Information</h6>
                <table class="table">
                    <tr>
                        <th style="width: 150px;">ID</th>
                        <td>{{ $service->id }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $service->title }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $service->slug }}</td>
                    </tr>
                    <tr>
                        <th>Order</th>
                        <td>{{ $service->order }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($service->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Additional Information</h6>
                <table class="table">
                    <tr>
                        <th style="width: 150px;">Image</th>
                        <td>{{ $service->image ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $service->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $service->updated_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <h6 class="text-muted">Short Description</h6>
        <div class="p-3 border rounded bg-light mb-4">
            {{ $service->short_description }}
        </div>
        
        <h6 class="text-muted">Content</h6>
        <div class="content-preview p-3 border rounded bg-light">
            {!! $service->content !!}
        </div>
        
        @if($service->image)
        <h6 class="text-muted mt-4">Image Preview</h6>
        <div class="text-center p-3 border rounded bg-light">
            <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" class="img-fluid" style="max-height: 300px;">
        </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Services
            </a>
            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i> Delete Service
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 