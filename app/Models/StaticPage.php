<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtmlInput;

class StaticPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'featured_image',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'content' => CleanHtmlInput::class,
        ];
    }
}
