<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
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
     * Display a listing of the pages.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $pages = Page::all();
        return view('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        return view('backend.pages.create');
    }

    /**
     * Store a newly created page in storage.
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
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        Page::create($validated);
        
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified page.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Page $page)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        return view('backend.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Page $page)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        return view('backend.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Page $page)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Only update slug if title has changed
        if ($page->title !== $request->title) {
            $validated['slug'] = Str::slug($request->title);
        }
        
        $page->update($validated);
        
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $page->delete();
        
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
} 