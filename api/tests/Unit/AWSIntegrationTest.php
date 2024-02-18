<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Services\PDFService;
use function PHPUnit\Framework\assertTrue;


class AWSIntegrationTest extends TestCase
{
    /**
     * @test
     * Let's make sure PHP unit runs
     */
    public function it_can_run_a_unit_test(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * It can convert a PDF file (or any file really as our validation will occur in the form request) to B64
     */
    public function it_can_find_a_locally_stored_pdf_and_convert_it_to_pdf()
    {
        $PDFService = new PDFService();
        $path ='pdf/sample.pdf';
        $pdf = $PDFService->convertPDFToB64($path);

        //Ascertain whether it's base64 encoded
        assertTrue(base64_encode(base64_decode($pdf, true)) === $pdf);
    }

    /**
     * @test 
     * It will search the local directory for sample.pdf if no file is provided and use that as a default
     */
    public function it_can_find_the_default_file_if_no_file_is_provided(){
        $PDFService = new PDFService();
        $pdf = $PDFService->convertPDFToB64();

        //Ascertain whether it's base64 encoded
        assertTrue(base64_encode(base64_decode($pdf, true)) === $pdf);
    }

}
