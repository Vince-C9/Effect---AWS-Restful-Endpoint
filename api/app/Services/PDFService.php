<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PDFService
{
    /**
     * Converts the associated file to base 64 encoded string
     *
     * @param $filepath
     * @return string
     */
    public function convertPDFToB64($filepath){
        return base64_encode(Storage::disk('public')->get($filepath));
    }
}
