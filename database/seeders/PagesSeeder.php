<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // About Page
        Page::create([
            'title' => 'About Us',
            'slug' => 'about',
            'content' => '<p class="about-main-desc">
                After more than 20 years of experience in the Saudi Arabia\'s Human Capital Development market, JAD Consulting (JADCO) was established to continue supporting the industry with a new inspired vision by the great Saudi Vision 2030.
            </p>
            <p>
                JADCO and its highly ranked international partners of Companies, Universities and SMEs are forming together an exclusive and innovative consortium to serve and be part of the revolution and development and support the transformation for the next levels.
            </p>
            <p>
                JADCO in collaboration with the best partners in the globe, customize and Tailor projects to bridge the gap and providing the latest technologies to ensure the max level of quality of deliverables, support local content and transform knowledge to meet the objectives of our clients.
            </p>',
            'meta_title' => 'About JADOO - Our Mission and Vision',
            'meta_description' => 'Learn about JADOO\'s mission, vision, and our commitment to education, training, and innovation.',
            'is_active' => true,
        ]);

        // Privacy Policy Page
        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '<h2>Privacy Policy</h2>
            <p>This Privacy Policy describes how your personal information is collected, used, and shared when you visit our website.</p>
            <h3>Personal Information We Collect</h3>
            <p>When you visit the Site, we automatically collect certain information about your device, including information about your web browser, IP address, time zone, and some of the cookies that are installed on your device.</p>
            <h3>How We Use Your Personal Information</h3>
            <p>We use the information that we collect generally to fulfill any orders placed through the Site (including processing your payment information, arranging for shipping, and providing you with invoices and/or order confirmations).</p>',
            'meta_title' => 'Privacy Policy - JADOO',
            'meta_description' => 'Read JADOO\'s privacy policy to understand how we collect, use, and protect your personal information.',
            'is_active' => true,
        ]);

        // Terms of Service Page
        Page::create([
            'title' => 'Terms of Service',
            'slug' => 'terms-of-service',
            'content' => '<h2>Terms of Service</h2>
            <p>These Terms of Service govern your use of our website located at jadoo.com (together or individually "Service").</p>
            <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>
            <h3>Intellectual Property</h3>
            <p>The Service and its original content, features and functionality are and will remain the exclusive property of JADOO and its licensors.</p>',
            'meta_title' => 'Terms of Service - JADOO',
            'meta_description' => 'Read JADOO\'s terms of service to understand the rules and regulations governing the use of our website and services.',
            'is_active' => true,
        ]);
    }
} 