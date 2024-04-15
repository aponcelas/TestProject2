<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;

class CoursesController extends Controller
{
    public function index(Request $request): Response
    {
        $courses = $this->getAllCourses();

        return Inertia::render('Courses', [
            'courses' => $courses,
        ]);
    }

    public function getAllCourses() 
    {
        $courses = Course::all();
        return $courses;
    }
}
