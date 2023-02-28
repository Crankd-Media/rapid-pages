<?php

namespace App\Models;

use Crankd\RapidPages\Traits\PageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Page extends Model
{
    use HasFactory;
    use PageTrait;
    // use slug as route key


}
