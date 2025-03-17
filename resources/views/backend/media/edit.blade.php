@extends('backend.layouts.app')

@section('title', 'Edit Media')
@section('header', 'Edit Media')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Media</h5>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Media
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="media-preview text-center p-3 border rounded">
                    @if(str_contains($media->mime_type ?? $media->file_type ?? '', 'image'))
                        <img src="{{ asset($media->path ?? $media->file_path) }}" alt="{{ $media->alt_text }}" class="img-fluid">
                    @else
                        <div class="file-icon p-4">
                            <i class="fas fa-file fa-4x text-secondary"></i>
                            <p class="mt-2">{{ pathinfo($media->filename ?? $media->name, PATHINFO_EXTENSION) }}</p>
                        </div>
                    @endif
                </div>
                <div class="mt-3">
                    <h6>File Information</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Filename</span>
                            <span class="text-muted">{{ $media->filename ?? $media->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Type</span>
                            <span class="text-muted">{{ $media->mime_type ?? $media->file_type ?? 'Unknown' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Size</span>
                            <span class="text-muted">{{ formatFileSize($media->size ?? $media->file_size ?? 0) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Uploaded</span>
                            <span class="text-muted">{{ $media->created_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="filename" value="{{ old('filename', $media->filename) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text" value="{{ old('alt_text', $media->alt_text) }}">
                        <small class="text-muted">Alternative text for screen readers. Important for SEO and accessibility.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $media->description) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="path" class="form-label">File Path</label>
                        <input type="text" class="form-control" id="path" value="{{ $media->path ?? $media->file_path }}" readonly>
                        <small class="text-muted">Use this path to reference this file in your content.</small>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Media</button>
                    </div>
                </form>
                
                <!-- Separate delete form to avoid nesting forms -->
                <div class="mt-4 pt-3 border-top">
                    <h6>Danger Zone</h6>
                    <p class="text-muted">Once you delete this media, there is no going back. Please be certain.</p>
                    <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Delete Media
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
function formatFileSize($size) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($size >= 1024 && $i < count($units) - 1) {
        $size /= 1024;
        $i++;
    }
    return round($size, 2) . ' ' . $units[$i];
}
@endphp 