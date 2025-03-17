@extends('backend.layouts.app')

@section('title', 'Media Library')
@section('header', 'Media Library')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Media</h5>
        <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
            <i class="fas fa-upload me-1"></i> Upload New Media
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($media->isEmpty())
            <div class="alert alert-info">
                No media files found. Upload some media to get started.
            </div>
        @else
            <div class="row">
                @foreach($media as $item)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100">
                            <div class="media-preview text-center p-2">
                                @if(str_contains($item->mime_type ?? $item->file_type ?? '', 'image'))
                                {{-- <h3>{{ asset($item->path ?? $item->file_path) }}</h3> --}}
                                    <img src="{{ asset($item->path ?? $item->file_path) }}" alt="{{ $item->alt_text }}" class="img-fluid" style="max-height: 150px;">
                                @else
                                    <div class="file-icon p-4">
                                        <i class="fas fa-file fa-4x text-secondary"></i>
                                        <p class="mt-2">{{ pathinfo($item->filename ?? $item->name, PATHINFO_EXTENSION) }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h6 class="card-title text-truncate">{{ $item->name ?? $item->filename }}</h6>
                                <p class="card-text small text-muted">
                                    {{ $item->alt_text ?? 'No alt text' }}
                                </p>
                                <p class="card-text small">
                                    <span class="badge bg-secondary">{{ formatFileSize($item->size ?? $item->file_size ?? 0) }}</span>
                                    <span class="badge bg-info">{{ $item->created_at->format('M d, Y') }}</span>
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $media->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation to all delete buttons
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this media? This action cannot be undone.')) {
                    this.submit();
                }
            });
        });
    });
</script>
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