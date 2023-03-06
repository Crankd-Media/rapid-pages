<?php

namespace Crankd\RapidPages\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SectionSetting;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    | 
    */
    public function index()
    {
        $pages = Page::all();
        $sections = Section::get();

        $compact = [
            'pages',
            'sections',
        ];

        // get view from config
        $view = config('rapid-pages.views.admin.pages.index');
        return view($view, compact($compact));
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

        // get view from config
        $view = config('rapid-pages.views.app.page.show');
        return view($view, compact($compact));
    }

    // create 
    public function create()
    {
        $slug = Str::uuid();
        $page = Page::create([
            'title' => 'Untitled',
            'slug' => $slug,
            'content' => '',
            'author_id' => auth()->user()->id,
        ]);
        $page_title = Section::where('slug', 'page_title')->first();
        $page->addSection($page_title, 0);

        // return page eidt
        $route = config('rapid-pages.routes.admin.pages.edit');
        return redirect()->route($route, $page);
    }

    public function edit(Page $page)
    {
        $compact = [
            'page',
        ];

        $view = config('rapid-pages.views.admin.pages.edit');
        return view($view, compact($compact));
    }

    // update 

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'nullable',
            'slug' => 'nullable',
            'sections' => 'nullable|array',
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

        // return back()->with('success', 'Page updated successfully');
    }


    public function destroy(Page $page)
    {
        $page->delete();
        $route = config('rapid-pages.routes.admin.pages.index');
        return redirect()->route($route);
    }

    /*
    |--------------------------------------------------------------------------
    | Page Sections
    |--------------------------------------------------------------------------
    | 
    */
    public function sections_create()
    {
        return view('admin.page.section-create');
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

        $route = config('rapid-pages.routes.admin.sections.edit');

        return redirect()->route($route, $section);
    }

    public function sections_edit(Section $section)
    {
        $compact = [
            'section',
        ];
        $view = config('rapid-pages.views.admin.sections.edit');

        return view('admin.page.section-edit', compact($compact));
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
            'fields' => $request->custom_fields ? $request->custom_fields : [],
        ]);


        // load section
        $section = Section::find($section->id);

        // if ajax request
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Section updated successfully',
            ]);
        }

        return back()->with('success', 'Section updated successfully');
    }

    public function sections_destroy(Section $section)
    {
        $section->delete();
        $route = config('rapid-pages.routes.admin.sections.index');
        if ($route == null) {
            $route = config('rapid-pages.routes.admin.pages.index');
        }

        return redirect()->route($route)->with('success', 'Section deleted successfully');
    }
}
