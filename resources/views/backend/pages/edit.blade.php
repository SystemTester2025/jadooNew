@extends('backend.layouts.app')

@section('title', 'Edit Page')
@section('header', 'Edit Page: ' . $page->title)

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Page Details</h5>
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

        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $page->title) }}" required>
                <small class="text-muted">The title of the page. Changing this will also update the slug.</small>
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" value="{{ $page->slug }}" disabled>
                <small class="text-muted">The slug is automatically generated from the title and used in the URL.</small>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control summernote" id="content" name="content" rows="10">{{ old('content', $page->content) }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
                        <small class="text-muted">Optional. Used for SEO purposes.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                        <small class="text-muted">Optional. Used for SEO purposes.</small>
                    </div>
                </div>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
                <small class="text-muted d-block">If checked, the page will be visible on the website.</small>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Page</button>
            </div>
        </form>
    </div>
</div>
@endsection 