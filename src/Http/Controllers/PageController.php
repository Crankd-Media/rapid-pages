<?php

namespace Crankd\RapidPages\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\SectionSetting;
use App\Http\Controllers\Controller;


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


        // dd($sections);


        $compact = [
            'page',
            'sections',
            'page_sections',
        ];

        return view('frontend.page.edit', compact($compact));
    }


    public function update(Request $request, Page $page)
    {

        $request->validate([
            'title' => 'nullable',
            'slug' => 'nullable',
        ]);

        $page->update([
            'title' => ($request->title) ? $request->title : $page->title,
            'slug' => $request->slug ? $request->slug : $page->slug,
        ]);


        if ($request->sections) {
            // get the missing sections from pagesections and rquest sections and remove the ones that are not in the request
            $pageSections = $page->sections()->get()->pluck('pivot.section_settings_id');
            $requestSections = collect($request->sections)->pluck('pivot.section_settings_id');
            $missingSectionsIds = $pageSections->diff($requestSections);

            // get page sections by section settings id and remove
            $missingSections = $page->sections()->whereIn('section_settings_id', $missingSectionsIds)->get();
            foreach ($missingSections as $missingSection) {
                $page->removeSection($missingSection);
            }

            $order = 0;
            foreach ($request->sections as $section) {
                if (isset($section['pivot'])) {
                    $page->updateSectionOrder($section['pivot']['section_settings_id'], $order);
                    $page->updateSectionSettings($section['pivot']['section_settings_id'], $section['fieldValues'], true);
                } else {
                    $sectionMedel = Section::find($section['id']);
                    $page->addSection($sectionMedel, $order, $section['fieldValues']);
                }
                $order++;
            }

            $sections = $page->sections()->get();
        }

        // if ajax request
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Page updated successfully',
                'sections' => $sections->toArray(),
                'request' => $request->sections,
            ], 200);
        }


        //  return back()->with('success', 'Page updated successfully');
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
