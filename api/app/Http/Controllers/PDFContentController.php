<?php

namespace App\Http\Controllers;

use App\Http\Requests\PDFUploadRequest;
use App\Services\PDFService;
use App\Services\TextractService;

class PDFContentController extends Controller
{

    private $textract;
    private $pdfService;
    public function __construct()
    {
        //Could probably facade this, make it a little less clunky
        $this->textract = new TextractService();
        $this->pdfService = new PDFService();
    }

    public function store(PDFUploadRequest $request){

        /**
         * Because I am using the SDK, it handles converting to Base64 for me (if their documentation is to be trusted!).
         * However... I have written a service that will handle the converting to/from stuff too,
         * for the purpose of covering all grounds.
         *
         * Find it at App/Services/PDFService.php
         */
        $file = $request->file('pdf')->getContent();
        $response = $this->textract->makeTextractAPICall($file);
        $savedData = $this->textract->parseAndStoreDocumentChunks($response, $request->file('pdf')->getClientOriginalName().'-'.date('Ymd-His'));
        return $savedData;
    }
}
