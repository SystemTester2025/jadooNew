<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display and update settings.
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('label')->get();
        $groups = $settings->pluck('group')->unique();
        
        return view('backend.settings.index', compact('settings', 'groups'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $settings = $request->except('_token', '_method');
        
        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Initialize default settings.
     */
    public function initialize()
    {
        $defaultSettings = [
            // General
            ['key' => 'site_title', 'value' => 'JADOO', 'type' => 'text', 'group' => 'general', 'label' => 'Site Title'],
            ['key' => 'site_description', 'value' => 'From Education and Training to Innovation', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description'],
            ['key' => 'logo', 'value' => 'images/logo/logo-black.png', 'type' => 'image', 'group' => 'general', 'label' => 'Logo'],
            
            // Colors
            ['key' => 'primary_color', 'value' => '#6b5ce7', 'type' => 'color', 'group' => 'colors', 'label' => 'Primary Color'],
            ['key' => 'secondary_color', 'value' => '#0099ff', 'type' => 'color', 'group' => 'colors', 'label' => 'Secondary Color'],
            ['key' => 'text_color', 'value' => '#333333', 'type' => 'color', 'group' => 'colors', 'label' => 'Text Color'],
            ['key' => 'background_color', 'value' => '#ffffff', 'type' => 'color', 'group' => 'colors', 'label' => 'Background Color'],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'jad@jadco.co', 'type' => 'text', 'group' => 'contact', 'label' => 'Contact Email'],
            ['key' => 'contact_phone', 'value' => '+966 123456789', 'type' => 'text', 'group' => 'contact', 'label' => 'Contact Phone'],
            ['key' => 'contact_address_sa', 'value' => 'Level 7, Building 4.07, Zone 4, King Abdullah Financial District (KAFD), Riyadh 13519, Saudi Arabia.', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Saudi Arabia Address'],
            ['key' => 'contact_address_usa', 'value' => '3972 Barranca Parkway, Ste J139, Irvine, CA 92606', 'type' => 'textarea', 'group' => 'contact', 'label' => 'USA Address'],
            ['key' => 'contact_address_uae', 'value' => 'A1, Dubai Digital Park, Dubai Silicon Oasis, Dubai, United Arab Emirates.', 'type' => 'textarea', 'group' => 'contact', 'label' => 'UAE Address'],
            
            // Social Media
            ['key' => 'youtube_url', 'value' => '#', 'type' => 'text', 'group' => 'social', 'label' => 'YouTube URL'],
            ['key' => 'linkedin_url', 'value' => '#', 'type' => 'text', 'group' => 'social', 'label' => 'LinkedIn URL'],
        ];
        
        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Default settings initialized successfully.');
    }
} 