<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        $settings = $this->getSettings();
        
        return view('frontend.index', compact('services', 'settings'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        $settings = $this->getSettings();
        
        return view('frontend.about', compact('page', 'settings'));
    }

    /**
     * Display a specific service page
     */
    public function service($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $settings = $this->getSettings();
        
        return view('frontend.services.show', compact('service', 'settings'));
    }
    
    /**
     * Display a custom page
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $settings = $this->getSettings();
        
        return view('frontend.page', compact('page', 'settings'));
    }
    
    /**
     * Get all settings for frontend
     */
    private function getSettings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return $settings;
    }
} 