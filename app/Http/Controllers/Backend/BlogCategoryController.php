<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Http\Requests\BlogCategoryRequest;

class BlogCategoryController extends Controller
{
    protected $moduleName;

    public function __construct()
    {
        //Module Name
        $this->moduleName = 'Blog Categories';
        view()->share('moduleName', $this->moduleName);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the search parameter from the request
        $search = request()->input('search');
        $status = request()->input('status');

        // Start building the query
        $query = BlogCategory::query();

        // Filter by status if provided
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                      ->orWhere('slug', 'like', '%'.$search.'%');
            });
        }

        $query->orderBy('id', 'desc');

        $pageData = $query->paginate(config('custom.pagination_per_page'));

        // Return the view with data
        return view('backend.blog-categories.index', compact('pageData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('backend.blog-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryRequest $request)
    {

        // If validation passes, proceed to saving the data
        $blogCategory = new BlogCategory();
        $blogCategory->name = $request->input('name');
        $blogCategory->slug = $request->input('slug');
        $blogCategory->parent_id = $request->input('parent_id');
        $blogCategory->description = $request->input('description');
        $blogCategory->meta_title = $request->input('meta_title');
        $blogCategory->meta_description = $request->input('meta_description');
        $blogCategory->meta_keywords = $request->input('meta_keywords');
        $blogCategory->status = $request->input('status');
        $blogCategory->save();

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
        $pageData = BlogCategory::findOrFail($id);
        $categories = BlogCategory::where('status', true)->where('id', '!=', $id)->get();
        return view('backend.blog-categories.edit', compact('pageData', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryRequest $request, $id)
    {
        // Find the existing record by ID
        $blogCategory = BlogCategory::findOrFail($id);

        // If validation passes, update the data
        $blogCategory->name = $request->input('name');
        $blogCategory->slug = $request->input('slug');
        $blogCategory->parent_id = $request->input('parent_id');
        $blogCategory->description = $request->input('description');
        $blogCategory->meta_title = $request->input('meta_title');
        $blogCategory->meta_description = $request->input('meta_description');
        $blogCategory->meta_keywords = $request->input('meta_keywords');
        $blogCategory->status = $request->input('status');
        $blogCategory->save();

        // Return JSON response for AJAX handling
        return response()->json(['status' => true, 'notification' => 'Record updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $blogCategory = BlogCategory::findOrFail($id);

            // Check if category has blogs
            if ($blogCategory->blogs()->count() > 0) {
                return redirect()->route('blog-categories.index')->with('error', 'Cannot delete category that has associated blogs.');
            }

            $blogCategory->delete();

            // Redirect back with a success message
            return redirect()->route('blog-categories.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            // Log the error message and stack trace
            \Log::error('Error deleting BlogCategory record', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'blog_category_id' => $id
            ]);

            // Redirect back with an error message
            return redirect()->route('blog-categories.index')->with('error', 'There was an error deleting the record.');
        }
    }
}
