<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course;

class QuizController extends Controller
{
    protected $moduleName;

    public function __construct()
    {
        //Module Name
        $this->moduleName = 'Quizzes';
        view()->share('moduleName', $this->moduleName);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the search parameter from the request
        $courseId = request()->input('course');
        $search = request()->input('search');
    
        // Start building the query
        $query = Quiz::query();
    
        // Filter by authenticated user's company_id if available
        if (auth()->user()->company_id) {
            $query->whereHas('course', function($q) {
                $q->where('company_id', auth()->user()->company_id);
            });
        }
    
        // Additional filtering by request input (optional)
        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%');
            });
        }      
    
        $query->orderBy('id', 'desc');
    
        $pageData = $query->paginate(config('custom.pagination_per_page'));
    
        // Get dropdown data for courses
        $courseList = Course::where('is_active', 1)->pluck('name', 'id')->toArray();
    
        // Return the view with data
        return view('backend.quizzes.index', compact('pageData', 'courseList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get dropdown data for courses
        $courseList = Course::where('is_active', 1)->pluck('name', 'id')->toArray();
        return view('backend.quizzes.create', compact('courseList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|min:3|max:200',
            'total_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1|lte:total_marks',
            'is_active' => 'required|boolean',
        ]);

        // If validation passes, proceed to saving the data
        $Quiz = new Quiz();
        $Quiz->course_id = $request->input('course_id');
        $Quiz->title = $request->input('title');
        $Quiz->total_marks = $request->input('total_marks');
        $Quiz->pass_marks = $request->input('pass_marks');
        $Quiz->is_active = $request->input('is_active');
        $Quiz->save();

        // Return JSON response for AJAX handling
        return response()->json(['status' => true, 'notification' => 'Record created successfully!']);
    }       

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageData = Quiz::findOrFail($id);
        $courseList = Course::where('is_active', 1)->pluck('name', 'id')->toArray();
        return view('backend.quizzes.edit', compact('pageData', 'courseList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the existing record by ID
        $Quiz = Quiz::findOrFail($id);
    
        // Validate the incoming data
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|min:3|max:200',
            'total_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1|lte:total_marks',
            'is_active' => 'required|boolean',
        ]);

        // If validation passes, update the data
        $Quiz->course_id = $request->input('course_id');
        $Quiz->title = $request->input('title');
        $Quiz->total_marks = $request->input('total_marks');
        $Quiz->pass_marks = $request->input('pass_marks');
        $Quiz->is_active = $request->input('is_active');
        $Quiz->save();
    
        // Return JSON response for AJAX handling
        return response()->json(['status' => true, 'notification' => 'Record updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Attempt to delete the record
            Quiz::destroy($id);
    
            // Redirect back with a success message
            return redirect()->route('quizzes.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            // Log the error message and stack trace
            \Log::error('Error deleting Quiz record', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'quiz_id' => $id
            ]);
    
            // Redirect back with an error message
            return redirect()->route('quizzes.index')->with('error', 'There was an error deleting the record.');
        }
    }    
}
