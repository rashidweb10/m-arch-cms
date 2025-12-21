<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    protected $moduleName;

    public function __construct()
    {
        //Module Name
        $this->moduleName = 'Blogs';
        view()->share('moduleName', $this->moduleName);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the search/filter parameters from the request
        $search = request()->input('search');
        $status = request()->input('status');

        // Start building the query
        $query = Blog::with('categories');

        // Filter by status if provided
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // Free-text search on title, slug, excerpt, content
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('slug', 'like', '%'.$search.'%')
                    ->orWhere('excerpt', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%');
            });
        }

        $query->orderBy('id', 'desc');

        $pageData = $query->paginate(config('custom.pagination_per_page'));

        // Return the view with data
        return view('backend.blogs.index', compact('pageData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('backend.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {

        // If validation passes, proceed to saving the data
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->slug = $request->input('slug');
        $blog->excerpt = $request->input('excerpt');
        $blog->content = $request->input('content');
        $blog->featured_image = $request->input('featured_image');
        $blog->status = $request->input('status');
        $blog->published_at = $request->input('published_at') ?: now();
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_description = $request->input('meta_description');
        $blog->meta_keywords = $request->input('meta_keywords');
        $blog->save();

        // Sync categories
        $blog->categories()->sync($request->input('categories', []));

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
        $pageData = Blog::with('categories')->findOrFail($id);
        $categories = BlogCategory::where('status', true)->get();
        return view('backend.blogs.edit', compact('pageData', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, $id)
    {
        // Find the existing record by ID
        $blog = Blog::findOrFail($id);

        // If validation passes, update the data
        $blog->title = $request->input('title');
        $blog->slug = $request->input('slug');
        $blog->excerpt = $request->input('excerpt');
        $blog->content = $request->input('content');
        $blog->featured_image = $request->input('featured_image');
        $blog->status = $request->input('status');
        $blog->published_at = $request->input('published_at') ?: now();
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_description = $request->input('meta_description');
        $blog->meta_keywords = $request->input('meta_keywords');
        $blog->save();

        // Sync categories
        $blog->categories()->sync($request->input('categories', []));

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
            $blog = Blog::findOrFail($id);
            $blog->delete();

            // Redirect back with a success message
            return redirect()->route('blogs.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            // Log the error message and stack trace
            \Log::error('Error deleting Blog record', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'blog_id' => $id
            ]);

            // Redirect back with an error message
            return redirect()->route('blogs.index')->with('error', 'There was an error deleting the record.');
        }
    }

    /**
     * Bulk delete blogs
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = explode(',', $request->input('ids'));

            if (empty($ids) || !is_array($ids)) {
                return response()->json(['status' => false, 'notification' => 'No items selected for deletion.']);
            }

            $deleted = Blog::whereIn('id', $ids)->delete();

            if ($deleted > 0) {
                return response()->json([
                    'status' => true,
                    'notification' => $deleted . ' record(s) deleted successfully!'
                ]);
            } else {
                return response()->json(['status' => false, 'notification' => 'No records were deleted.']);
            }
        } catch (\Exception $e) {
            \Log::error('Error bulk deleting Blog records', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'ids' => $request->input('ids')
            ]);

            return response()->json(['status' => false, 'notification' => 'There was an error deleting the records.']);
        }
    }

    /**
     * Bulk publish blogs
     */
    public function bulkPublish(Request $request)
    {
        try {
            $ids = explode(',', $request->input('ids'));

            if (empty($ids) || !is_array($ids)) {
                return response()->json(['status' => false, 'notification' => 'No items selected for publishing.']);
            }

            $updated = Blog::whereIn('id', $ids)->update(['status' => 'published']);

            if ($updated > 0) {
                return response()->json([
                    'status' => true,
                    'notification' => $updated . ' record(s) published successfully!'
                ]);
            } else {
                return response()->json(['status' => false, 'notification' => 'No records were published.']);
            }
        } catch (\Exception $e) {
            \Log::error('Error bulk publishing Blog records', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'ids' => $request->input('ids')
            ]);

            return response()->json(['status' => false, 'notification' => 'There was an error publishing the records.']);
        }
    }

    /**
     * Bulk draft blogs
     */
    public function bulkDraft(Request $request)
    {
        try {
            $ids = explode(',', $request->input('ids'));

            if (empty($ids) || !is_array($ids)) {
                return response()->json(['status' => false, 'notification' => 'No items selected for drafting.']);
            }

            $updated = Blog::whereIn('id', $ids)->update(['status' => 'draft']);

            if ($updated > 0) {
                return response()->json([
                    'status' => true,
                    'notification' => $updated . ' record(s) drafted successfully!'
                ]);
            } else {
                return response()->json(['status' => false, 'notification' => 'No records were drafted.']);
            }
        } catch (\Exception $e) {
            \Log::error('Error bulk drafting Blog records', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'ids' => $request->input('ids')
            ]);

            return response()->json(['status' => false, 'notification' => 'There was an error drafting the records.']);
        }
    }
}
