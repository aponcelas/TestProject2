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

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stage' => 'required|string|in:ESO,BTX,CF',
            'description' => 'required|string|max:150',
            'state' => 'required|string|in:Public,Privat',
        ]);
    
        $course = Course::findOrFail($id);

        $course->nombre = $validatedData['name'];
        $course->etapa = $validatedData['stage'];
        $course->descripcion = $validatedData['description'];
        $course->activo = $validatedData['state'];

        $course->save();        
    }

    function destroy(Request $request, $id)
    {
        $course = Course::find($id);
        
        if ($course) {
            $course->delete();
        }
    }

    function add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stage' => 'required|string|in:ESO,BTX,CF',
            'description' => 'required|string|max:150',
            'state' => 'required|string|in:Public,Privat',
        ]);

        $course = Course::create([
            'nombre' => $validatedData['name'],
            'etapa' => $validatedData['stage'],
            'descripcion' => $validatedData['description'],
            'activo' => $validatedData['state'],
        ]);
    }

    public function generateJson() 
    {
        $courses = Course::all();
        $json = $courses->toJson(JSON_PRETTY_PRINT);

        return response()->json(json_decode($json));
    }
}
