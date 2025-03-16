<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AI and Advanced Technologies
        Service::create([
            'title' => 'AI and Advanced Technologies',
            'slug' => 'ai',
            'short_description' => 'AI represents a transformative technology with the potential to revolutionize organizations services and operations. By leveraging AI, organizations can enhance efficiency, improve decision-making and deliver superior to public.',
            'content' => '<p>AI represents a transformative technology with the potential to revolutionize organizations services and operations. By leveraging AI, organizations can enhance efficiency, improve decision-making and deliver superior to public.</p>
            <h2>Our AI Services Include:</h2>
            <ul>
                <li>Machine Learning Solutions</li>
                <li>Natural Language Processing</li>
                <li>Computer Vision Applications</li>
                <li>AI Strategy Consulting</li>
                <li>Custom AI Development</li>
            </ul>
            <p>Our team of AI experts works closely with clients to understand their unique challenges and develop tailored solutions that drive real business value.</p>',
            'image' => 'images/services/ai.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        // Education and Training
        Service::create([
            'title' => 'Education and Training',
            'slug' => 'education',
            'short_description' => 'We provide comprehensive education and training programs to help individuals and organizations achieve their goals and stay ahead in the competitive market.',
            'content' => '<p>We provide comprehensive education and training programs to help individuals and organizations achieve their goals and stay ahead in the competitive market.</p>
            <h2>Our Education Services Include:</h2>
            <ul>
                <li>Corporate Training Programs</li>
                <li>Professional Development Courses</li>
                <li>Educational Consulting</li>
                <li>Curriculum Development</li>
                <li>E-Learning Solutions</li>
            </ul>
            <p>Our education and training programs are designed to meet the specific needs of our clients, with a focus on practical skills and knowledge that can be immediately applied in the workplace.</p>',
            'image' => 'images/services/education.jpg',
            'order' => 2,
            'is_active' => true,
        ]);

        // E-Gaming and eSport
        Service::create([
            'title' => 'E-Gaming and eSport',
            'slug' => 'gaming',
            'short_description' => 'We offer cutting-edge solutions and platforms for e-gaming and eSport, providing an immersive and engaging experience for gamers and enthusiasts.',
            'content' => '<p>We offer cutting-edge solutions and platforms for e-gaming and eSport, providing an immersive and engaging experience for gamers and enthusiasts.</p>
            <h2>Our Gaming Services Include:</h2>
            <ul>
                <li>eSports Tournament Organization</li>
                <li>Gaming Platform Development</li>
                <li>Gaming Community Management</li>
                <li>Gaming Strategy Consulting</li>
                <li>Gaming Content Creation</li>
            </ul>
            <p>Our e-gaming and eSport solutions are designed to create engaging and competitive environments that attract and retain players while providing opportunities for skill development and community building.</p>',
            'image' => 'images/services/gaming.jpg',
            'order' => 3,
            'is_active' => true,
        ]);

        // Arts and Entertainment
        Service::create([
            'title' => 'Arts and Entertainment',
            'slug' => 'arts',
            'short_description' => 'Our arts and entertainment services bring creativity and innovation to the forefront, offering unique experiences and opportunities for artists and audiences alike.',
            'content' => '<p>Our arts and entertainment services bring creativity and innovation to the forefront, offering unique experiences and opportunities for artists and audiences alike.</p>
            <h2>Our Arts Services Include:</h2>
            <ul>
                <li>Event Planning and Management</li>
                <li>Artist Development Programs</li>
                <li>Creative Content Production</li>
                <li>Arts Education Initiatives</li>
                <li>Cultural Exchange Programs</li>
            </ul>
            <p>We believe in the power of arts and entertainment to inspire, educate, and transform communities, and our services are designed to support and promote creative expression in all its forms.</p>',
            'image' => 'images/services/arts.jpg',
            'order' => 4,
            'is_active' => true,
        ]);

        // Scholarship Programs
        Service::create([
            'title' => 'Scholarship Programs Management',
            'slug' => 'scholarship',
            'short_description' => 'With more than 20 years in managing scholarship programs with several Saudi governmental sponsors, we are experts of providing full and comprehensive plans and services to meet the sponsor\'s vision and targets.',
            'content' => '<p>With more than 20 years in managing scholarship programs with several Saudi governmental sponsors, we are experts of providing full and comprehensive plans and services to meet the sponsor\'s vision and targets.</p>
            <h2>Our Scholarship Services Include:</h2>
            <ul>
                <li>Candidate Selection Criteria</li>
                <li>Universities Selection Criteria</li>
                <li>Program bylaws and regulations</li>
                <li>Student Journey plan</li>
                <li>Counseling & students development plans</li>
                <li>Pre-Departure preparatory programs</li>
                <li>Enroll students into international universities</li>
                <li>Workshops, awareness sessions and summits</li>
                <li>Pre travel and post travel logistics</li>
                <li>Overseas continual support</li>
            </ul>
            <p>Our scholarship management services are designed to support students throughout their educational journey, from selection and preparation to graduation and beyond.</p>',
            'image' => 'images/services/scholar.jpg',
            'order' => 5,
            'is_active' => true,
        ]);
    }
} 