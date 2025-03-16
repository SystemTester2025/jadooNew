<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the media.
     */
    public function index()
    {
        $media = Media::orderBy('created_at', 'desc')->paginate(20);
        
        return view('backend.media.index', compact('media'));
    }

    /**
     * Show the form for uploading new media.
     */
    public function create()
    {
        return view('backend.media.upload');
    }

    /**
     * Store a newly created media in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'alt_text' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('media', $filename, 'public');
        
        Media::create([
            'filename' => $filename,
            'path' => 'storage/' . $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $request->alt_text,
        ]);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    /**
     * Update the specified media in storage.
     */
    public function update(Request $request, Media $media)
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
        ]);
        
        $media->update([
            'alt_text' => $request->alt_text,
        ]);
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media updated successfully.');
    }

    /**
     * Remove the specified media from storage.
     */
    public function destroy(Media $media)
    {
        // Remove the file from storage
        $path = str_replace('storage/', '', $media->path);
        Storage::disk('public')->delete($path);
        
        // Delete the database record
        $media->delete();
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }
} 