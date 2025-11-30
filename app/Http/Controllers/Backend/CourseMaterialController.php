<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseMaterial;
use App\Models\Course;

class CourseMaterialController extends Controller
{
    protected $moduleName;

    public function __construct()
    {
        //Module Name
        $this->moduleName = 'Course Materials';
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
        $status = request()->input('status');
    
        // Start building the query
        $query = CourseMaterial::with('course');
    
        // Filter by course if provided
        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        // Filter by status if provided
        if ($status !== null && $status !== '') {
            $query->where('is_active', $status);
        }

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }      
    
        $query->orderBy('id', 'desc');
    
        $pageData = $query->paginate(5);
    
        // Get dropdown data for courses
        $courseList = Course::where('is_active', 1)->orderBy('name', 'asc')->get();
    
        // Return the view with data
        return view('backend.course-materials.index', compact('pageData', 'courseList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courseList = Course::where('is_active', 1)->orderBy('name', 'asc')->get();
        return view('backend.course-materials.create', compact('courseList'));
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
            'description' => 'nullable|string',
            'attachments' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        // If validation passes, proceed to saving the data
        $courseMaterial = new CourseMaterial();
        $courseMaterial->course_id = $request->input('course_id');
        $courseMaterial->title = $request->input('title');
        $courseMaterial->description = $request->input('description');
        $courseMaterial->attachments = $request->input('attachments');
        $courseMaterial->is_active = $request->input('is_active');
        $courseMaterial->save();

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
        $pageData = CourseMaterial::findOrFail($id);
        $courseList = Course::where('is_active', 1)->orWhere('id', $pageData->course_id)->orderBy('name', 'asc')->get();
        return view('backend.course-materials.edit', compact('pageData', 'courseList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the existing record by ID
        $courseMaterial = CourseMaterial::findOrFail($id);
    
        // Validate the incoming data
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string',
            'attachments' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
    
        // If validation passes, update the data
        $courseMaterial->course_id = $request->input('course_id');
        $courseMaterial->title = $request->input('title');
        $courseMaterial->description = $request->input('description');
        $courseMaterial->attachments = $request->input('attachments');
        $courseMaterial->is_active = $request->input('is_active');
        $courseMaterial->save();
    
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
            CourseMaterial::destroy($id);
    
            // Redirect back with a success message
            return redirect()->route('course-materials.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            // Log the error message and stack trace
            \Log::error('Error deleting CourseMaterial record', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'course_material_id' => $id
            ]);
    
            // Redirect back with an error message
            return redirect()->route('course-materials.index')->with('error', 'There was an error deleting the record.');
        }
    }    
}

