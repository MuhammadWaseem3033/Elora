<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class DesignImage extends Model
{
    protected $fillable = [
        'design_id',
        'image',
        'alt_text',
        'sort_order',
    ];

    #[Override]
    public function casts(): array
    {
        return parent::casts();
    }

    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class);
    }
}
