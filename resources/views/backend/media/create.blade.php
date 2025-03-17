@extends('backend.layouts.app')

@section('title', 'Upload Media')
@section('header', 'Upload New Media')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Upload Media</h5>
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

        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" class="form-control" id="file" name="file" required>
                <small class="text-muted">Maximum file size: 10MB</small>
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label">Name (Optional)</label>
                <input type="text" class="form-control" id="name" name="filename" value="{{ old('filename') }}">
                <small class="text-muted">If left blank, the original filename will be used.</small>
            </div>
            
            <div class="mb-3">
                <label for="alt_text" class="form-label">Alt Text</label>
                <input type="text" class="form-control" id="alt_text" name="alt_text" value="{{ old('alt_text') }}">
                <small class="text-muted">Alternative text for screen readers. Important for SEO and accessibility.</small>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description (Optional)</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                <small class="text-muted">A brief description of the media file.</small>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Upload Media</button>
            </div>
        </form>
    </div>
</div>
@endsection 