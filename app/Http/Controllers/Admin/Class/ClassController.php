<?php

namespace App\Http\Controllers\Admin\Class;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    /**
     * ダッシュボード画面 (Lesson, CourseCategory, Course)
     * 
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Classes/Index');
    }
}
