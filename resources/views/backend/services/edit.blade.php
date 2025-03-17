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
                <label for="image" class="form-label">Featured Image</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $service->image) }}" readonly>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mediaModal">
                        <i class="fas fa-images"></i> Select Image
                    </button>
                </div>
                <small class="text-muted">Select an image from the media library for this service.</small>
                <div id="imagePreview" class="mt-2 {{ old('image', $service->image) ? '' : 'd-none' }}">
                    <img src="{{ old('image', $service->image) ? asset(old('image', $service->image)) : '' }}" class="img-thumbnail" style="max-height: 150px;">
                </div>
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

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Select Image from Media Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if($media->isEmpty())
                        <div class="col-12">
                            <div class="alert alert-info">
                                No media files found. <a href="{{ route('admin.media.create') }}" target="_blank">Upload some media</a> to get started.
                            </div>
                        </div>
                    @else
                        @foreach($media as $item)
                            @if(str_contains($item->mime_type ?? $item->file_type ?? '', 'image'))
                                <div class="col-md-3 col-sm-4 mb-3">
                                    <div class="card h-100 media-item" data-path="{{ $item->path }}" style="cursor: pointer;">
                                        <div class="media-preview text-center p-2">
                                            <img src="{{ asset($item->path) }}" alt="{{ $item->alt_text }}" class="img-fluid" style="max-height: 120px;">
                                        </div>
                                        <div class="card-body p-2">
                                            <p class="card-text small text-truncate">{{ $item->name ?? $item->filename }}</p>
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
    });
</script>
@endsection 