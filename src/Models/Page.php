<?php

namespace App\Models;

use Crankd\RapidPages\Traits\PageTrait;
use Illuminate\Database\Eloquent\Model;
use Crankd\RapidPages\Traits\HasSectionsTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    use PageTrait;
    // use slug as route key


    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id',
        'status',
        'settings',
    ];
}
