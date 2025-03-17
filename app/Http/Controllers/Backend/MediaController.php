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

        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
                'filename' => 'nullable|string|max:255',
                'alt_text' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Check if we have a file in the request
            if (!$request->hasFile('file')) {
                Log::error('No file found in request');
                return redirect()->back()->with('error', 'No file found in the request. Please try again.');
            }

            $file = $request->file('file');
            
            // Debug information to help identify the issue
            Log::info('Uploaded file details', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'path' => $file->getRealPath(),
                'error' => $file->getError()
            ]);
            
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Make sure target directory exists
            $targetDir = public_path('images/uploads');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            // Instead of using move(), try using copy() which tends to work better on Windows
            if (!copy($file->getRealPath(), $targetDir . '/' . $filename)) {
                throw new \Exception("Failed to copy uploaded file");
            }

            $path = 'images/uploads/' . $filename;
            
            Media::create([
                'filename' => $request->input('filename', $file->getClientOriginalName()),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'alt_text' => $request->alt_text,
                'description' => $request->description,
            ]);
            
            return redirect()->route('admin.media.index')
                ->with('success', 'Media uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage(), [
                'file' => $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : 'No file',
                'error' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'File upload failed: ' . $e->getMessage());
        }
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
                'filename' => 'nullable|string|max:255',
                'alt_text' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);
            
            $media->update([
                'filename' => $request->filename ?? $media->filename,
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
            
            // Remove the file from public directory if path exists
            if ($path) {
                $fullPath = public_path($path);
                
                // Check if file exists before attempting to delete
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                } else {
                    // Log that file doesn't exist but continue
                    Log::warning("File not found for deletion: {$fullPath}");
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