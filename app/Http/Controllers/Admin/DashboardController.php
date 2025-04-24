<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admins']);
    }

    // Admin Dashboard
    public function index()
    {
        return Inertia::render('Admin/Index');
    }
}
