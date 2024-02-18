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
     * Fake an API call to the Textract API and handle the response
     */
    public function it_can_find_a_locally_stored_pdf_and_convert_it_to_pdf()
    {
        $PDFService = new PDFService();
        $path ='pdf/sample.pdf';
        $pdf = $PDFService->convertPDFToB64($path);

        //Ascertain whether it's base64 encoded
        assertTrue(base64_encode(base64_decode($pdf, true)) === $pdf);
    }



}
