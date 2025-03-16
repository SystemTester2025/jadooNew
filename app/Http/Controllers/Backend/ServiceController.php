<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Check if user is admin
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function checkAdmin()
    {
        if (!Auth::user()->is_admin) {
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

        $services = Service::orderBy('order')->paginate(10);
        
        return view('backend.services.index', compact('services'));
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

        $media = Media::orderBy('created_at', 'desc')->get();
        
        return view('backend.services.create', compact('media'));
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

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        // Set default order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = Service::max('order') + 1;
        }
        
        Service::create($validated);
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
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

        return view('backend.services.show', compact('service'));
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

        $media = Media::orderBy('created_at', 'desc')->get();
        
        return view('backend.services.edit', compact('service', 'media'));
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

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Only update slug if title has changed
        if ($service->title !== $request->title) {
            $validated['slug'] = Str::slug($request->title);
        }
        
        $service->update($validated);
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
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

        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
} 