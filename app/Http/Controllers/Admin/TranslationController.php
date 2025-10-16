<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $query = Translation::with('language')
        ->where('language_id', $request->language);
        if($request->ajax()){
            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    $edit = route('admin.translations.edit', $row->id);
                    return view('admin.partials.actions', compact('edit','row'))->render();
                })
                ->editColumn('value', fn($row) => Str::limit($row->value, 50))
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.translations.index');
    }

    public function edit(Translation $translation)
    {
        return view('admin.translations.edit', compact('translation'));
    }

    public function update(Request $request, Translation $translation)
    {
        $request->validate([
            'value' => 'nullable|string',
        ]);

        $translation->update(['value' => $request->value]);

        return redirect()->route('admin.translations.index', ['language' => $translation->language_id])->with('success', 'Translation updated.');
    }

    public function create()
    {
        return view('admin.translations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'language_id' => 'required|exists:languages,locale',
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value' => 'nullable|string',
        ]);

        Translation::create($request->all());

        return redirect()->route('admin.translations.index')->with('success', 'Translation created.');
    }
}
