@extends('backend.layouts.app')

@section('title', 'Upload Media')
@section('header', 'Upload Media')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <span>Upload New Media</span>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Media Library
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="file" class="form-label">File <span class="text-danger">*</span></label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maximum file size: 10MB. Supported formats: JPG, PNG, GIF, PDF, DOC, DOCX, XLS, XLSX.</div>
            </div>
            
            <div class="mb-3">
                <label for="alt_text" class="form-label">Alt Text</label>
                <input type="text" class="form-control @error('alt_text') is-invalid @enderror" id="alt_text" name="alt_text" value="{{ old('alt_text') }}">
                @error('alt_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Alt text helps with accessibility and SEO.</div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload Media
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <span>Upload Guidelines</span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Image Recommendations</h5>
                <ul>
                    <li>Use high-quality images (minimum 1200px width for banners)</li>
                    <li>Optimize images for web to reduce file size</li>
                    <li>Use descriptive filenames (e.g., "corporate-meeting.jpg" instead of "IMG001.jpg")</li>
                    <li>Always provide alt text for accessibility</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>Supported File Types</h5>
                <ul>
                    <li><strong>Images:</strong> JPG, PNG, GIF, SVG</li>
                    <li><strong>Documents:</strong> PDF, DOC, DOCX</li>
                    <li><strong>Spreadsheets:</strong> XLS, XLSX</li>
                    <li><strong>Maximum file size:</strong> 10MB</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Preview image on file selection
        $('#file').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Auto-fill alt text from filename if empty
                    if (!$('#alt_text').val()) {
                        let fileName = file.name.split('.').slice(0, -1).join('.');
                        // Replace hyphens and underscores with spaces
                        fileName = fileName.replace(/[-_]/g, ' ');
                        // Capitalize first letter of each word
                        fileName = fileName.replace(/\b\w/g, l => l.toUpperCase());
                        $('#alt_text').val(fileName);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection 