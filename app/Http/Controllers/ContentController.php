<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Models\Resource;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;

class ContentController extends Controller
{
    public function index(Request $request): Response
    {
        $content = $this->getAllContents();
        $courses = $this->getAllCourses();

        return Inertia::render('Content', [
            'content' => $content,
            'courses' => $courses,
        ]);
    }

    public function getAllContents() 
    {
        $content = Course::with('resources')->get();
        return $content;
    }

    public function getAllCourses() 
    {
        $courses = Course::all();
        return $courses;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:150',
            'visibility' => 'required|string|in:Public,Privat',
            'course_id' => 'required|exists:courses,id'
        ]);
    
        $course = Resource::findOrFail($id);

        $course->title = $validatedData['title'];
        $course->content = $validatedData['content'];
        $course->visibility = $validatedData['visibility'];
        $course->course_id = $validatedData['course_id'];

        $course->save();        
    }

    function destroy(Request $request, $id)
    {
        $content = Resource::find($id);
        
        if ($content) {
            $content->delete();
        }
    }

    function add(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:150',
            'visibility' => 'required|string|in:Public,Privat',
            'course_id' => 'required|exists:courses,id'
        ]);

        $content = Resource::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'visibility' => $validatedData['visibility'],
            'course_id' => $validatedData['course_id'],
        ]);
    }
}
