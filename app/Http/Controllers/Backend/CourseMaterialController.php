<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseMaterial;
use App\Models\Course;
use App\Models\CourseCategory;

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
        // Get the search/filter parameters from the request
        $categoryId = request()->input('category');
        $courseId   = request()->input('course');
        $search     = request()->input('search');
        $status     = request()->input('status');
    
        // Start building the query
        $query = CourseMaterial::with('course');
    
        // Filter by category (via the related course) if provided
        if ($categoryId) {
            $query->whereHas('course', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Filter by course if provided
        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        // Filter by status if provided
        if ($status !== null && $status !== '') {
            $query->where('is_active', $status);
        }

        // Free-text search on title / description
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }      
    
        $query->orderBy('id', 'desc');
    
        $pageData = $query->paginate(5);
    
        // Get dropdown data for categories and courses
        $categoryList = CourseCategory::where('is_active', 1)->orderBy('name', 'asc')->get();

        $courseQuery = Course::where('is_active', 1);
        if ($categoryId) {
            $courseQuery->where('category_id', $categoryId);
        }
        $courseList = $courseQuery->orderBy('name', 'asc')->get();
    
        // Return the view with data
        return view('backend.course-materials.index', compact('pageData', 'courseList', 'categoryList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryList = CourseCategory::where('is_active', 1)->orderBy('name', 'asc')->get();
        //$courseList = Course::where('is_active', 1)->orderBy('name', 'asc')->get();
        return view('backend.course-materials.create', compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'category_id' => 'nullable|exists:course_categories,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string',
            'attachments' => 'nullable|string',
            'sorting_id' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        // If validation passes, proceed to saving the data
        $courseMaterial = new CourseMaterial();
        $courseMaterial->category_id = $request->input('category_id');
        $courseMaterial->course_id = $request->input('course_id');
        $courseMaterial->title = $request->input('title');
        $courseMaterial->description = $request->input('description');
        $courseMaterial->attachments = $request->input('attachments');
        $courseMaterial->sorting_id = $request->input('sorting_id');
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
        $pageData = CourseMaterial::with('course')->findOrFail($id);
        $categoryList = CourseCategory::where('is_active', 1)->orderBy('name', 'asc')->get();
        
        // Get courses - include the current course even if inactive, and all active courses
        $courseList = Course::where('is_active', 1)
            ->orWhere('id', $pageData->course_id)
            ->orderBy('name', 'asc')
            ->get();
        
        return view('backend.course-materials.edit', compact('pageData', 'courseList', 'categoryList'));
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
            'category_id' => 'nullable|exists:course_categories,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string',
            'attachments' => 'nullable|string',
            'sorting_id' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);
    
        // If validation passes, update the data
        $courseMaterial->category_id = $request->input('category_id');
        $courseMaterial->course_id = $request->input('course_id');
        $courseMaterial->title = $request->input('title');
        $courseMaterial->description = $request->input('description');
        $courseMaterial->attachments = $request->input('attachments');
        $courseMaterial->sorting_id = $request->input('sorting_id');
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

