<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    /**
     * Check if user is admin
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'You do not have permission to access the admin area.');
        }
        
        return null;
    }

    /**
     * Display a listing of the media.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $media = Media::orderBy('created_at', 'desc')->paginate(20);
        
        return view('backend.media.index', compact('media'));
    }

    /**
     * Show the form for uploading new media.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('backend.media.create');
    }

    /**
     * Store a newly created media in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'name' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('media', $filename, 'public');
        
        Media::create([
            'name' => $request->input('name', $file->getClientOriginalName()),
            'filename' => $filename,
            'path' => 'storage/' . $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $request->alt_text,
            'description' => $request->description,
        ]);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    /**
     * Display the specified media.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        try {
            // Find the media
            $media = Media::find($id);
            
            if (!$media) {
                return redirect()->route('admin.media.index')
                    ->with('error', 'Media not found. It may have been deleted.');
            }

            return view('backend.media.show', compact('media'));
        } catch (\Exception $e) {
            Log::error('Error showing media: ' . $e->getMessage());
            
            return redirect()->route('admin.media.index')
                ->with('error', 'Error showing media: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified media.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        try {
            // Find the media
            $media = Media::find($id);
            
            if (!$media) {
                return redirect()->route('admin.media.index')
                    ->with('error', 'Media not found. It may have been deleted.');
            }

            return view('backend.media.edit', compact('media'));
        } catch (\Exception $e) {
            Log::error('Error editing media: ' . $e->getMessage());
            
            return redirect()->route('admin.media.index')
                ->with('error', 'Error editing media: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified media in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        try {
            // Find the media
            $media = Media::find($id);
            
            if (!$media) {
                return redirect()->route('admin.media.index')
                    ->with('error', 'Media not found. It may have been deleted.');
            }

            $request->validate([
                'name' => 'nullable|string|max:255',
                'alt_text' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);
            
            $media->update([
                'name' => $request->name ?? $media->name ?? $media->filename,
                'alt_text' => $request->alt_text,
                'description' => $request->description,
            ]);
            
            return redirect()->route('admin.media.index')
                ->with('success', 'Media updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating media: ' . $e->getMessage());
            
            return redirect()->route('admin.media.index')
                ->with('error', 'Error updating media: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified media from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        try {
            // First check if the media exists
            $media = Media::find($id);
            
            if (!$media) {
                return redirect()->route('admin.media.index')
                    ->with('error', 'Media not found. It may have been already deleted.');
            }
            
            // Get the file path
            $path = $media->path ?? $media->file_path;
            
            // Remove the file from storage if path exists
            if ($path) {
                // Convert the public URL path to a storage path
                $storagePath = str_replace('storage/', 'public/', $path);
                
                // Check if file exists before attempting to delete
                if (Storage::exists($storagePath)) {
                    Storage::delete($storagePath);
                } else {
                    // Try alternative path formats
                    $alternativePath = 'public/' . basename($path);
                    if (Storage::exists($alternativePath)) {
                        Storage::delete($alternativePath);
                    }
                    // If file doesn't exist in either location, log it but continue
                    // This allows deleting database records even if files are missing
                }
            }
            
            // Delete the database record
            $media->delete();
            
            return redirect()->route('admin.media.index')
                ->with('success', 'Media deleted successfully.');
                
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error deleting media: ' . $e->getMessage());
            
            return redirect()->route('admin.media.index')
                ->with('error', 'Error deleting media: ' . $e->getMessage());
        }
    }
} 