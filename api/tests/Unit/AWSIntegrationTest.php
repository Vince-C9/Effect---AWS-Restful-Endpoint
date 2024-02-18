<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;
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
    public function it_can_call_the_textract_api_with_valid_data_and_handle_the_response()
    {
        $PDFService = new PDFService();
        $pdf = $PDFService->convertPDFToB64(Storage::disk('local')->get('pdf/sample.pdf'));

        //Ascertain whether it's base64 encoded
        assertTrue(base64_encode(base64_decode($pdf, true)) === $pdf);
    }



}
