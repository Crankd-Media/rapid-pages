<?php

namespace App\Models;

use App\Casts\Json;
use App\Casts\CustomFields;
use App\Models\SectionSetting;
use Spatie\MediaLibrary\HasMedia;

use App\Traits\UseCustomFieldsTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Crankd\RapidCustomFields\Traits\HasIndividualCustomFields;


class Section extends Model implements HasMedia
{
    use HasFactory;
    use UseCustomFieldsTrait;
    use HasIndividualCustomFields;
    use InteractsWithMedia;


    protected $rapid_custom_fields = [
        'fields' => 'fields',
        'values' => 'custom_field_values'
    ];

    protected $fillable = [
        'name',
        'slug',
        'fields',
    ];

    // setting is json
    protected $casts = [
        'fields' => CustomFields::class, // AsCollection, AsArrayObject, 'array', 'json', 'object', 'collection', 'date', 'datetime', 'timestamp'
    ];

    public function sectionables()
    {
        return $this->morphByMany()->withPivot('order', 'section_settings_id');
    }

    // has many section settings
    public function sectionSettings()
    {
        return $this->hasMany(SectionSetting::class);
    }

    public function getModelPivotAttribute()
    {
        return SectionSetting::find($this->pivot->section_settings_id);
    }

    public function getSetting($key)
    {
        return $this->modelPivot->settings->get('container');
    }

    public function getSectionSettingsIdAttribute()
    {
        return $this->pivot->section_settings_id;
    }
}
