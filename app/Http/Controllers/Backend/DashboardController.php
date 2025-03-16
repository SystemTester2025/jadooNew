<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\Media;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics and quick access links
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Gather statistics for the dashboard
        $stats = [
            'pages' => Page::count(),
            'services' => Service::count(),
            'media' => Media::count() ?? 0,
        ];

        return view('backend.dashboard.index', compact('stats'));
    }
} 