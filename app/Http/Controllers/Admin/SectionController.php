<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use DataTables;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return DataTables::of(Section::query())
                ->addColumn('actions', function ($section) {
                    $edit = route('admin.sections.edit',$section->id);
                    $delete = route('admin.sections.destroy',$section->id);
                    return view('admin.partials.actions', compact('edit', 'delete'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.sections.index');
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|unique:sections,key',
            'name' => 'required|string',
        ]);

        $content = [];
        $keys = $request->input('content_keys', []);
        $types = $request->input('content_types', []);
        $values = $request->input('content_values', []);

        // Fetch all files separately
        $files = $request->allFiles()['content_values'] ?? [];

        foreach ($keys as $index => $key) {
            $type = $types[$index] ?? 'text';

            if ($type === 'image' && isset($files[$index])) {
                $image = $files[$index];
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/sections'), $filename);
                $content[$key] = $filename;
            }

            elseif ($type === 'multi_select') {
                $value = $values[$index] ?? '';
                $content[$key] = is_array($value) ? $value : explode(',', $value);
            }

            else {
                $value = $values[$index] ?? null;
                $content[$key] = $value;
            }
        }

        Section::create([
            'key' => $validated['key'],
            'name' => $validated['name'],
            'default_content' => $content,
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully.');
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
    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'key' => 'required|unique:sections,key,' . $section->id,
            'name' => 'required|string',
        ]);

        $content = [];
        $keys = $request->input('content_keys', []);
        $types = $request->input('content_types', []);
        $values = $request->input('content_values', []);
        $existingImages = $request->input('existing_images', []);

        foreach ($keys as $index => $key) {
            $type = $types[$index] ?? 'text';
            $value = $values[$index] ?? null;

            if ($type === 'image') {
                if ($request->hasFile("content_values.$index")) {
                    $image = $request->file("content_values.$index");
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/sections'), $filename);
                    $content[$key] = $filename;
                } else {
                    $content[$key] = $existingImages[$index] ?? null;
                }
            } elseif ($type === 'multi_select') {
                $content[$key] = is_array($value) ? $value : explode(',', $value);
            } else {
                $content[$key] = $value;
            }
        }

        $section->update([
            'key' => $validated['key'],
            'name' => $validated['name'],
            'default_content' => $content,
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully.');
    }

    public function loadItems($type)
    {
        $model = match($type) {
            'services' => \App\Models\Service::translatedIn(app()->getLocale())->get(),
            'testimonials' => [],
            'blogs' => \App\Models\Blog::translatedIn(app()->getLocale())->get(),
            default => null,
        };

        if (!$model) return response()->json([]);

        return $model->pluck('title', 'id');
    }
}
