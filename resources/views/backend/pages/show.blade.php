@extends('backend.layouts.app')

@section('title', 'View Page')
@section('header', 'View Page: ' . $page->title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Page Details</h5>
        <div>
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('page', $page->slug) }}" class="btn btn-info" target="_blank">
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
                        <td>{{ $page->id }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $page->title }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $page->slug }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($page->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">SEO Information</h6>
                <table class="table">
                    <tr>
                        <th style="width: 150px;">Meta Title</th>
                        <td>{{ $page->meta_title ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>Meta Description</th>
                        <td>{{ $page->meta_description ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $page->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $page->updated_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <h6 class="text-muted">Content</h6>
        <div class="content-preview p-3 border rounded bg-light">
            {!! $page->content !!}
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Pages
            </a>
            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i> Delete Page
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 