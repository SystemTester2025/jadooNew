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
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'pages' => Page::count(),
            'services' => Service::count(),
            'media' => Media::count(),
        ];

        return view('backend.dashboard.index', compact('stats'));
    }
} 