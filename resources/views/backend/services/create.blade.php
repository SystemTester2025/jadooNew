@extends('backend.layouts.app')

@section('title', 'Create Service')
@section('header', 'Create New Service')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary">Service Details</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        <small class="text-muted">The title will also generate the slug.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description" class="form-label fw-semibold">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="2" required>{{ old('short_description') }}</textarea>
                        <small class="text-muted">Brief description for service listings.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold">Content</label>
                        <textarea class="form-control summernote" id="content" name="content" rows="8">{{ old('content') }}</textarea>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Featured Image</h6>
                        </div>
                        <div class="card-body">
                            <div id="imagePreview" class="text-center mb-3 {{ old('image') ? '' : 'd-none' }}">
                                <img src="{{ old('image') ? asset(old('image')) : '' }}" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                            
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="image" name="image" value="{{ old('image') }}" readonly>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mediaModal">
                                    <i class="fas fa-images"></i> Select
                                </button>
                            </div>
                            <small class="text-muted">Select an image from the media library.</small>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="order" class="form-label fw-semibold">Display Order</label>
                                <input type="number" class="form-control form-control-sm" id="order" name="order" value="{{ old('order') }}">
                            </div>
                            
                            <div class="mb-3 mb-0">
                                <label for="is_active" class="form-label fw-semibold">Status</label>
                                <select class="form-select form-select-sm" id="is_active" name="is_active">
                                    <option value="1" {{ old('is_active', 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', 1) ? '' : 'selected' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Create Service
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Select Image from Media Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    @if($media->isEmpty())
                        <div class="col-12">
                            <div class="alert alert-info">
                                No media files found. <a href="{{ route('admin.media.create') }}" target="_blank">Upload some media</a> to get started.
                            </div>
                        </div>
                    @else
                        @foreach($media as $item)
                            @if(str_contains($item->mime_type ?? $item->file_type ?? '', 'image'))
                                <div class="col-md-3 col-sm-4">
                                    <div class="card h-100 media-item shadow-sm" data-path="{{ $item->path }}" style="cursor: pointer;">
                                        <div class="media-preview text-center p-2">
                                            <img src="{{ asset($item->path) }}" alt="{{ $item->alt_text }}" class="img-fluid" style="max-height: 120px;">
                                        </div>
                                        <div class="card-body p-2">
                                            <p class="card-text small text-truncate mb-0">{{ $item->name ?? $item->filename }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle media item selection
        const mediaItems = document.querySelectorAll('.media-item');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const mediaModal = document.getElementById('mediaModal');
        const modal = bootstrap.Modal.getOrCreateInstance(mediaModal);
        
        mediaItems.forEach(item => {
            item.addEventListener('click', function() {
                const path = this.getAttribute('data-path');
                imageInput.value = path;
                
                // Update preview
                const previewImg = imagePreview.querySelector('img');
                previewImg.src = '{{ asset("") }}' + path;
                imagePreview.classList.remove('d-none');
                
                // Close modal
                modal.hide();
            });
        });
        
        // Highlight selected media item
        mediaItems.forEach(item => {
            if(item.getAttribute('data-path') === imageInput.value) {
                item.classList.add('border-primary');
            }
        });
    });
</script>
@endsection 