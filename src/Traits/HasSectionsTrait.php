<?php

namespace Crankd\RapidPages\Traits;

use App\Models\Section;
use Illuminate\Support\Str;
use App\Models\SectionSetting;
use Illuminate\Database\Eloquent\Model;

trait HasSectionsTrait
{

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionables')
            ->withPivot('id', 'order', 'section_settings_id')
            ->orderBy('order');
    }

    /**
     * Get the sections on the page
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSections()
    {
        // get sections with the section settign relation
        $sections = $this->sections()->get();
        foreach ($sections as $section) {

            $fieldValues = $section->getFieldValuesFromPivotModel(new SectionSetting(), 'section_settings_id');
            $section->fieldValues = $fieldValues;
        }

        return $sections;
    }


    /**
     * Attach a section to the page
     *
     * @param  \App\Models\Section  $section
     * @param  int  $order
     * @param  array  $settings
     * @return void
     */
    public function addSection(Section $section, int $order, array $fieldValues = [])
    {

        $values = [];
        foreach ($fieldValues as $setting) {
            $values[$setting['key']] = (isset($setting['value'])) ? $setting['value'] : null;
        }
        $settings = $values;


        $section_setting = SectionSetting::create(['settings' => $settings]);
        // add section to page
        $this->sections()->save($section, ['order' => $order, 'section_settings_id' => $section_setting->id]);

        return [
            'section' => $section,
            'order' => $order,
            'settings' => $section_setting
        ];
    }

    /**
     * Update a section on the page
     *
     * @param  \App\Models\Section  $section
     * @param  int  $order
     * @param  array  $settings
     * @return void
     */
    public function updateSection(Section $section, $order = 0, $settings = [])
    {
        // get this page's section
        $page_section = $this->sections()->where('section_id', $section->id)->first();

        // update the settings
        // if settings is not empty
        $section_setting = null;
        if (!empty($settings)) {
            $section_setting =  $this->updateSectionSettings($page_section->pivot->section_settings_id, $settings);
        }

        // check if updated
        $page_section = $this->sections()->where('section_id', $section->id)->first();

        return [
            'section' => $section,
            'order' => $order,
            'settings' => $section_setting,
        ];
    }

    /**
     * Remove a section from the page
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function removeSection(Section $section)
    {
        $settingsId = $section->pivot->section_settings_id;
        $sectionables = $this->sections()->where('section_settings_id', $settingsId)->first();
        $sectionables->pivot->delete();
        $section_settings = SectionSetting::find($settingsId);
        if ($section_settings) {
            $section_settings->delete();
        }
    }

    public function updateSectionOrder($settingsId, $newOrder)
    {
        $this->sections()->where('section_settings_id', $settingsId)->update(['order' => $newOrder]);
    }


    public function updateSectionSettings($settingsId, $settings, $format = false)
    {
        if ($format == true) {
            $values = [];
            foreach ($settings as $setting) {
                if ($setting['type'] == 'repeater') {
                    $values[$setting['key']]['values'] = $setting['values'];
                } else {
                    $values[$setting['key']] = (isset($setting['value'])) ? $setting['value'] : null;
                }
            }
            $settings = $values;
        }
        $section_settings = SectionSetting::find($settingsId);
        $section_settings->update(['settings' => $settings]);
        return $section_settings;
    }
}
