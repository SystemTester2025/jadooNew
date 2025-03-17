@extends('backend.layouts.app')

@section('title', 'Upload Media')
@section('header', 'Upload New Media')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Upload Media</h5>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Media
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

        <div class="row">
            <!-- Form Section - Left Side -->
            <div class="col-md-8">
                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="mediaUploadForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file" name="file" required accept="image/*,application/pdf">
                        <small class="text-muted">Maximum file size: 10MB. Supported formats: JPG, PNG, GIF, PDF</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="filename" class="form-label">Name (Optional)</label>
                        <input type="text" class="form-control" id="filename" name="filename" value="{{ old('filename') }}">
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
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i> Upload Media
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Preview Section - Right Side -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">File Preview</h6>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center" id="previewContainer" style="min-height: 300px;">
                        <div class="text-center" id="defaultPreview">
                            <i class="fas fa-cloud-upload-alt fa-4x text-muted"></i>
                            <p class="mt-3 text-muted">Select a file to preview</p>
                        </div>
                        <div class="text-center d-none" id="imagePreview">
                            <img src="" alt="Preview" class="img-fluid" style="max-height: 300px; max-width: 100%;">
                            <div class="mt-2 text-muted small" id="imageDetails"></div>
                        </div>
                        <div class="text-center d-none" id="filePreview">
                            <i class="fas fa-file fa-4x text-primary"></i>
                            <p class="mt-2 mb-0" id="fileName"></p>
                            <p class="text-muted small" id="fileType"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upload Guidelines -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">Upload Guidelines</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-info-circle me-2"></i>Image Recommendations</h6>
                        <ul class="small">
                            <li>Use high-quality images (minimum 1200px width for banners)</li>
                            <li>Optimize images for web to reduce file size</li>
                            <li>Use descriptive filenames (e.g., "corporate-meeting.jpg")</li>
                            <li>Always provide alt text for accessibility</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-check-circle me-2"></i>Supported File Types</h6>
                        <ul class="small">
                            <li><strong>Images:</strong> JPG, PNG, GIF, SVG</li>
                            <li><strong>Documents:</strong> PDF</li>
                            <li><strong>Maximum file size:</strong> 10MB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file');
        const defaultPreview = document.getElementById('defaultPreview');
        const imagePreview = document.getElementById('imagePreview');
        const filePreview = document.getElementById('filePreview');
        const previewImage = imagePreview.querySelector('img');
        const imageDetails = document.getElementById('imageDetails');
        const fileName = document.getElementById('fileName');
        const fileType = document.getElementById('fileType');
        const altTextInput = document.getElementById('alt_text');
        
        fileInput.addEventListener('change', function() {
            // Reset previews
            defaultPreview.classList.add('d-none');
            imagePreview.classList.add('d-none');
            filePreview.classList.add('d-none');
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                
                // Display file name
                const displayName = file.name.length > 25 
                    ? file.name.substring(0, 22) + '...' 
                    : file.name;
                
                // Format file size
                const fileSize = formatFileSize(file.size);
                
                if (file.type.match('image.*')) {
                    // Handle image files
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imageDetails.textContent = `${displayName} (${fileSize})`;
                        imagePreview.classList.remove('d-none');
                        
                        // Suggest file name as alt text if empty
                        if (!altTextInput.value) {
                            const nameWithoutExt = file.name.replace(/\.[^/.]+$/, "");
                            altTextInput.value = nameWithoutExt.replace(/-|_/g, " ");
                        }
                        
                        // Create an image object to get dimensions
                        const img = new Image();
                        img.onload = function() {
                            imageDetails.textContent = `${displayName} (${fileSize}) - ${this.width}×${this.height}px`;
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Handle non-image files
                    fileName.textContent = displayName;
                    fileType.textContent = `${file.type} (${fileSize})`;
                    filePreview.classList.remove('d-none');
                }
            } else {
                // No file selected
                defaultPreview.classList.remove('d-none');
            }
        });
        
        // Function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>
@endsection 