<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicSection;
use App\Models\Blog;
use Illuminate\Http\Request;
use DataTables;

class DynamicSectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(DynamicSection::query())
                ->addColumn('template_type', function ($section) {
                    return ucfirst(str_replace('_', ' ', $section->template_type));
                })
                ->addColumn('posts_count', function ($section) {
                    return $section->posts()->count();
                })
                ->addColumn('actions', function ($section) {
                    $edit = route('admin.dynamic-sections.edit', $section->id);
                    $delete = route('admin.dynamic-sections.destroy', $section->id);
                    $manage = route('admin.dynamic-sections.manage-posts', $section->id);
                    return view('admin.partials.dynamic-section-actions', compact('edit', 'delete', 'manage'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        
        return view('admin.dynamic-sections.index');
    }

    public function create()
    {
        return view('admin.dynamic-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_type' => 'required|in:template_1,template_2',
            'is_active' => 'boolean',
        ]);

        DynamicSection::create($validated);

        return redirect()->route('admin.homepagesection.index')
                        ->with('success', 'Dynamic section created successfully.');
    }

    public function edit(DynamicSection $dynamicSection)
    {
        return view('admin.dynamic-sections.edit', compact('dynamicSection'));
    }

    public function update(Request $request, DynamicSection $dynamicSection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_type' => 'required|in:template_1,template_2',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $dynamicSection->update($validated);

        return redirect()->route('admin.homepagesection.index')
                        ->with('success', 'Dynamic section updated successfully.');
    }

    public function destroy(DynamicSection $dynamicSection)
    {
        $dynamicSection->delete();
        return redirect()->route('admin.homepagesection.index')
                        ->with('success', 'Dynamic section deleted successfully.');
    }

    public function managePosts(DynamicSection $dynamicSection)
    {
        $assignedPosts = $dynamicSection->posts()->get();
        
        return view('admin.dynamic-sections.manage-posts', compact('dynamicSection', 'assignedPosts'));
    }

    public function assignPost(Request $request, DynamicSection $dynamicSection)
    {
        $request->validate([
            'blog_ids' => 'required|array|min:1',
            'blog_ids.*' => 'exists:blogs,id',
            'sort_order' => 'integer|min:0'
        ]);

        $blogIds = $request->blog_ids;
        $startingSortOrder = $request->sort_order ?? 0;
        $attachedCount = 0;

        // Attach each post with consecutive sort order
        foreach ($blogIds as $index => $blogId) {
            // Check if post is not already assigned
            if (!$dynamicSection->posts()->where('blog_id', $blogId)->exists()) {
                $dynamicSection->posts()->attach($blogId, [
                    'is_featured' => false,
                    'sort_order' => $startingSortOrder + $index
                ]);
                $attachedCount++;
            }
        }

        $message = $attachedCount > 0 
            ? "Successfully assigned {$attachedCount} post(s)."
            : "No new posts were assigned (they may already be assigned).";

        return redirect()->back()->with('success', $message);
    }

    public function removePost(DynamicSection $dynamicSection, Blog $blog)
    {
        $dynamicSection->posts()->detach($blog->id);
        return redirect()->back()->with('success', 'Post removed successfully.');
    }

    public function updatePostOrder(Request $request, DynamicSection $dynamicSection)
    {
        $request->validate([
            'posts' => 'required|array',
            'posts.*.id' => 'required|exists:blogs,id',
            'posts.*.sort_order' => 'required|integer|min:0',
            'posts.*.is_featured' => 'boolean'
        ]);

        foreach ($request->posts as $post) {
            $dynamicSection->posts()->updateExistingPivot($post['id'], [
                'sort_order' => $post['sort_order'],
                'is_featured' => $post['is_featured'] ?? false
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function searchPosts(Request $request, DynamicSection $dynamicSection)
    {
        $query = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 10;

        // Get posts that are not already assigned to this section
        $assignedPostIds = $dynamicSection->posts()->pluck('blog_id')->toArray();
        
        $posts = \App\Models\Blog::where('title', 'like', "%{$query}%")
            ->whereNotIn('id', $assignedPostIds)
            ->select('id', 'title')
            ->orderBy('title')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total()
        ]);
    }
}
