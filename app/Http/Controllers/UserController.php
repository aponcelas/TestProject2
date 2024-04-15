<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Course;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $courses = $this->getAllVisibleCourses();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'courses' => $courses,
        ]);
    }

    public function getAllVisibleCourses() 
    {
        $courses = Course::where('state', 'Public')->get();
        return $courses;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
        ]);
    
        $user = User::findOrFail($id);

        $user->fill($validatedData);

        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();         
    }

    function destroy(Request $request, $id)
    {
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
        }
    }
}
