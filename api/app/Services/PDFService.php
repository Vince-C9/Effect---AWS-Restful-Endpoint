<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PDFService
{
    /**
     * Converts the associated file to base 64 encoded string if it's not already one!
     *
     * @param $filepath
     * @return string
     */
    public function convertPDFToB64($file){
        return $this->getIsBase64($file) ? $file : base64_encode($file);
    }

    /**
     * Checks to see whether we've receive a B64 string or not and returns true/false based on this.
     *
     * @param $file
     * @return bool
     */
    private function getIsBase64($file){
        return base64_encode(base64_decode($file, true)) === $file;
    }


    /**
     * Decodes base64 file to real file, if it is encoded.
     * @param $file
     * @return bool
     */

    public function convertB64toPDF($file){
        return $this->getIsBase64($file) ? base64_decode($file) : $file;
    }




}
