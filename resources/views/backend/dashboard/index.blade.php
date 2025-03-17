@extends('backend.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Pages</h5>
                        <h2 class="mb-0">{{ $stats['pages'] }}</h2>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <i class="fas fa-file-alt fa-2x text-primary"></i>
                    </div>
                </div>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-primary mt-3">Manage Pages</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Services</h5>
                        <h2 class="mb-0">{{ $stats['services'] }}</h2>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <i class="fas fa-cogs fa-2x text-primary"></i>
                    </div>
                </div>
                <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-primary mt-3">Manage Services</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Media</h5>
                        <h2 class="mb-0">{{ $stats['media'] }}</h2>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <i class="fas fa-images fa-2x text-primary"></i>
                    </div>
                </div>
                <a href="{{ route('admin.media.index') }}" class="btn btn-sm btn-primary mt-3">Manage Media</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Quick Actions
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('admin.pages.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Add New Page
                    </a>
                    <a href="{{ route('admin.services.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Add New Service
                    </a>
                    <a href="{{ route('admin.media.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-upload me-2"></i> Upload Media
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-sliders-h me-2"></i> Manage Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                System Information
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Laravel Version</th>
                            <td>{{ app()->version() }}</td>
                        </tr>
                        <tr>
                            <th>PHP Version</th>
                            <td>{{ phpversion() }}</td>
                        </tr>
                        <tr>
                            <th>Server</th>
                            <td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <th>Database</th>
                            <td>{{ config('database.connections.'.config('database.default').'.driver') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 