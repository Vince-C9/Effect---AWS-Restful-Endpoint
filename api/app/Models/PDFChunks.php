<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PDFChunks extends Model
{
    use HasFactory;
    protected $fillable = [
        'p_d_f_contents_id',
        'block_data',
        'text',
        'block_type',
        'confidence',
    ];


    /**
     * Associate to parent content
     *
     * @return BelongsTo
     */
    public function PDFContent(): BelongsTo
    {
        return $this->belongsTo(PDFcontent::class);
    }

}
