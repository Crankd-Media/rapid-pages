<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\SectionSetting;

class PageController extends Controller
{

    // index
    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index', compact('pages'));
    }

    public function show($slug = '')
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            abort(404);
        }

        $page_sections = $page->getSections();

        $compact = [
            'page',
            'page_sections',
        ];

        return view('frontend.page.show', compact($compact));
    }

    // create 
    public function create()
    {
        // create random slug with uuid
        $slug = \Str::uuid();

        $page = Page::create([
            'title' => 'Untitled',
            'slug' => $slug,
            'content' => '',
            'author_id' => auth()->user()->id,
        ]);
        $page_title = Section::where('slug', 'page_title')->first();
        $page_title_settings = config('sections.section_settings.page_title.settings');

        $page->addSection($page_title, 0, $page_title_settings);

        // return page eidt
        return redirect()->route('frontend.page.edit', $page);
    }

    public function edit(Page $page)
    {
        $sections = Section::get();
        // unset settings from sections
        foreach ($sections as $section) {
            $values = [];
            $fields = $section->fields;

            foreach ($fields as $field) {
                $field->value = null;
                if ($field->type == 'link' && empty($field->value)) {
                    $field->value = [
                        'label' => $field->title,
                        'show' => false,
                        'target' => '_self',
                        'type' => 'link',
                        'url' => '',
                        'title' => ''
                    ];
                }
                $values[$field->key] = $field;
            }

            $section->fieldValues = $values;
        }

        // dd($sections);

        $page_sections = $page->getSections();
        $page->sections = $page_sections;

        $compact = [
            'page',
            'sections',
            'page_sections',
        ];

        return view('frontend.page.edit', compact($compact));
    }

    // destroy
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index');
    }

    /*
    |--------------------------------------------------------------------------
    | Page Sections
    |--------------------------------------------------------------------------
    | 
    */
    public function sections_index()
    {
        $sections = Section::get();
        $compact = [
            'sections',
        ];
        return view('admin.page.sections.index', compact($compact));
    }

    public function sections_create()
    {
        return view('admin.page.sections.create');
    }

    public function sections_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $section = Section::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'settings' => $request->settings,
        ]);

        return redirect()->route('admin.sections.index');
    }

    public function sections_edit(Section $section)
    {
        $compact = [
            'section',
        ];
        return view('admin.page.sections.edit', compact($compact));
    }

    public function sections_update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'nullable',
            'slug' => 'nullable',
        ]);

        $section->update([
            'name' => ($request->name) ? $request->name : $section->name,
            'slug' => $request->slug ? $request->slug : $section->slug,
            // 'fields' => $request->custom_fields,
        ]);

        // if ajax request
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Section updated successfully',
            ]);
        }

        return redirect()->route('admin.sections.index');
    }

    public function sections_destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index');
    }
}
