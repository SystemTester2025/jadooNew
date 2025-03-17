<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics and quick access links
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'You do not have permission to access the admin area.');
        }

        // Gather statistics for the dashboard
        $stats = [
            'pages' => Page::count(),
            'services' => Service::count(),
            'media' => Media::count() ?? 0,
        ];

        return view('backend.dashboard.index', compact('stats'));
    }
} 