<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
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
            
            // Statistics
            ['key' => 'stat_institutes', 'value' => '15', 'type' => 'text', 'group' => 'statistics', 'label' => 'Number of Institutes'],
            ['key' => 'stat_institutes_text', 'value' => 'Cross disciplinary boundaries', 'type' => 'text', 'group' => 'statistics', 'label' => 'Institutes Text'],
            ['key' => 'stat_libraries', 'value' => '20', 'type' => 'text', 'group' => 'statistics', 'label' => 'Number of Libraries'],
            ['key' => 'stat_libraries_text', 'value' => 'Hold over 12 million items', 'type' => 'text', 'group' => 'statistics', 'label' => 'Libraries Text'],
            ['key' => 'stat_budget', 'value' => '2.2', 'type' => 'text', 'group' => 'statistics', 'label' => 'Budget in Billions'],
            ['key' => 'stat_budget_text', 'value' => 'Sponsored research budget', 'type' => 'text', 'group' => 'statistics', 'label' => 'Budget Text'],
            
            // Hero Section
            ['key' => 'hero_title', 'value' => 'FROM EDUCATION AND TRAINING TO INNOVATION', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Title'],
            ['key' => 'hero_description', 'value' => 'JADOO brings innovative solutions to education and technology, transforming the way we learn and interact with the digital world.', 'type' => 'textarea', 'group' => 'hero', 'label' => 'Hero Description'],
            ['key' => 'hero_button_text', 'value' => 'Discover More', 'type' => 'text', 'group' => 'hero', 'label' => 'Hero Button Text'],
            
            // Contact Section
            ['key' => 'contact_heading', 'value' => 'We Listen, design your vision and bring it to life...', 'type' => 'text', 'group' => 'contact_section', 'label' => 'Contact Heading'],
            ['key' => 'contact_subheading', 'value' => 'Let\'s Talk', 'type' => 'text', 'group' => 'contact_section', 'label' => 'Contact Subheading'],
        ];
        
        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
} 