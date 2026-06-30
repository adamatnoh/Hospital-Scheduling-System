<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'announcements' => [
                ['id' => 1, 'image' => '/images/1.jpg', 'title' => 'Hospital Update'],
                ['id' => 2, 'image' => '/images/2.jpg', 'title' => 'Staff Notice'],
                ['id' => 3, 'image' => '/images/3.jpg', 'title' => 'Schedule Reminder'],
            ],
        ]);
    }
}
