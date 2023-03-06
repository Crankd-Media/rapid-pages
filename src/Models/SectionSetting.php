<?php

namespace App\Models;

use App\Casts\Json;
use App\Casts\CustomFields;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Crankd\RapidCustomFields\Traits\HasIndividualCustomFields;

class SectionSetting extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasIndividualCustomFields;


    public $rapid_custom_fields = [
        'fields' => null,
        'values' => 'settings'
    ];

    protected $fillable = [
        'settings',
    ];

    // setting is json
    protected $casts = [
        'settings' => CustomFields::class,
        // AsCollection, AsArrayObject, 'array', 'json', 'object', 'collection', 'date', 'datetime', 'timestamp'
    ];
}
