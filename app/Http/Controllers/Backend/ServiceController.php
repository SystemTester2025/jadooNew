<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Check if user is admin
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'You do not have permission to access the admin area.');
        }
        
        return null;
    }

    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            $services = Service::orderBy('order')->paginate(10);
            
            return view('backend.services.index', compact('services'));
        } catch (\Exception $e) {
            Log::error('Error loading services index: ' . $e->getMessage());
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error loading services: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            $media = Media::orderBy('created_at', 'desc')->get();
            
            return view('backend.services.create', compact('media'));
        } catch (\Exception $e) {
            Log::error('Error loading service create form: ' . $e->getMessage());
            
            return redirect()->route('admin.services.index')
                ->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:services,title',
                'short_description' => 'required|string',
                'content' => 'required|string',
                'image' => 'nullable|string',
                'order' => 'nullable|integer',
                'is_active' => 'boolean',
            ], [
                'title.unique' => 'A service with this title already exists. Please use a different title.'
            ]);

            $validated['slug'] = Str::slug($request->title);
            
            // Set default order if not provided
            if (!isset($validated['order'])) {
                $validated['order'] = Service::max('order') + 1;
            }
            
            Service::create($validated);
            
            return redirect()->route('admin.services.index')
                ->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating service: ' . $e->getMessage());
            
            // Check if the error is related to a duplicate entry
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->route('admin.services.create')
                    ->with('error', 'A service with this title already exists. Please use a different title.')
                    ->withInput();
            }
            
            return redirect()->route('admin.services.create')
                ->with('error', 'Error creating service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Service $service)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            // Check if service exists
            if (!$service || !$service->exists) {
                return redirect()->route('admin.services.index')
                    ->with('error', 'Service not found.');
            }
            
            return view('backend.services.show', compact('service'));
        } catch (\Exception $e) {
            Log::error('Error showing service: ' . $e->getMessage());
            
            return redirect()->route('admin.services.index')
                ->with('error', 'Error showing service: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Service $service)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            // Check if service exists
            if (!$service || !$service->exists) {
                return redirect()->route('admin.services.index')
                    ->with('error', 'Service not found.');
            }
            
            $media = Media::orderBy('created_at', 'desc')->get();
            
            return view('backend.services.edit', compact('service', 'media'));
        } catch (\Exception $e) {
            Log::error('Error loading service edit form: ' . $e->getMessage());
            
            return redirect()->route('admin.services.index')
                ->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Service $service)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            // Check if service exists
            if (!$service || !$service->exists) {
                return redirect()->route('admin.services.index')
                    ->with('error', 'Service not found.');
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:services,title,'.$service->id,
                'short_description' => 'required|string',
                'content' => 'required|string',
                'image' => 'nullable|string',
                'order' => 'nullable|integer',
                'is_active' => 'boolean',
            ], [
                'title.unique' => 'Another service with this title already exists. Please use a different title.'
            ]);

            // Only update slug if title has changed
            if ($service->title !== $request->title) {
                $validated['slug'] = Str::slug($request->title);
            }
            
            $service->update($validated);
            
            return redirect()->route('admin.services.index')
                ->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating service: ' . $e->getMessage());
            
            // Check if the error is related to a duplicate entry
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->route('admin.services.edit', $service)
                    ->with('error', 'Another service with this title already exists. Please use a different title.')
                    ->withInput();
            }
            
            return redirect()->route('admin.services.edit', $service)
                ->with('error', 'Error updating service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        try {
            // Check if service exists
            if (!$service || !$service->exists) {
                return redirect()->route('admin.services.index')
                    ->with('error', 'Service not found or already deleted.');
            }
            
            $service->delete();
            
            return redirect()->route('admin.services.index')
                ->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting service: ' . $e->getMessage());
            
            return redirect()->route('admin.services.index')
                ->with('error', 'Error deleting service: ' . $e->getMessage());
        }
    }
} 