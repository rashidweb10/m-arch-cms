<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;

class CourseController extends Controller
{
    protected $moduleName;

    public function __construct()
    {
        //Module Name
        $this->moduleName = 'Courses';
        view()->share('moduleName', $this->moduleName);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the search parameter from the request
        $categoryId = request()->input('category');
        $search = request()->input('search');
        $status = request()->input('status');
    
        // Start building the query
        $query = Course::with('category');
    
        // Filter by category if provided
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by status if provided
        if ($status !== null && $status !== '') {
            $query->where('is_active', $status);
        }

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        }      
    
        $query->orderBy('id', 'desc');
    
        $pageData = $query->paginate(5);
    
        // Get dropdown data for categories
        $categoryList = CourseCategory::where('is_active', 1)->orderBy('name', 'asc')->get();
    
        // Return the view with data
        return view('backend.courses.index', compact('pageData', 'categoryList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryList = CourseCategory::where('is_active', 1)->orderBy('name', 'asc')->get();
        return view('backend.courses.create', compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:200',
            'image' => 'required',
            'category_id' => 'required|exists:course_categories,id',
            'is_active' => 'required|boolean',
        ]);

        // If validation passes, proceed to saving the data
        $course = new Course();
        $course->name = $request->input('name');
        $course->image = $request->input('image');
        $course->category_id = $request->input('category_id');
        $course->is_active = $request->input('is_active');
        $course->save();

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
        $pageData = Course::findOrFail($id);
        $categoryList = CourseCategory::where('is_active', 1)->orWhereIn('id', $pageData->pluck('category_id'))->orderBy('name', 'asc')->get();
        return view('backend.courses.edit', compact('pageData', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the existing record by ID
        $course = Course::findOrFail($id);
    
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:200',
            'image' => 'required',
            'category_id' => 'required|exists:course_categories,id',
            'is_active' => 'required|boolean',
        ]);
    
        // If validation passes, update the data
        $course->name = $request->input('name');
        $course->image = $request->input('image');
        $course->category_id = $request->input('category_id');
        $course->is_active = $request->input('is_active');
        $course->save();
    
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
            Course::destroy($id);
    
            // Redirect back with a success message
            return redirect()->route('courses.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            // Log the error message and stack trace
            \Log::error('Error deleting Course record', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'course_id' => $id
            ]);
    
            // Redirect back with an error message
            return redirect()->route('courses.index')->with('error', 'There was an error deleting the record.');
        }
    }    
}
