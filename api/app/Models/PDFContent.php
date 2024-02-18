<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PDFContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pages',
    ];


    /**
     * Get all associated blocks (chunks)
     *
     * @return HasMany
     */
    public function PDFChunks(): HasMany
    {
        return $this->hasMany(PDFChunks::class);
    }
}
