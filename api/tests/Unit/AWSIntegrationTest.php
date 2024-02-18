<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
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
     * It makes a call to AWS Textract using the AWS SDK & returns the expected object
     *
     * NOTE:: At this stage, this test is a 'live' call to the AWS service.  This is -bad- and we would typically want to fake these calls.
     * The reason being, we don't want to worry about testing someone elses software.  We want to intercept the call and return the expected response
     * via our faker, so that we can be sure our code handles it correctly.
     *
     * 1. We don't want to be bound by AWS going down (as it is one to do from time to time) and if it does, we don't want our tests to fail.
     * 2. We don't want to be charged for running our tests, that would be silly!   We could write in a specific scenario whereby this test only runs on
     *    a specific situation, for example, only ever in our CI/CD or only ever locally.
     *
     * I will circle back to this if there's time and move it to be a faked call
     */
    public function it_can_call_aws_textract_and_return_the_expected_result(){
        //Alias didn't want to work!  Would normally look into this but it seems fairly low prio (subject to coding principles/standards in place).
        $textract = App::make('aws')->createClient('textract');
        $file = Storage::disk('public')->get('pdf/sample.pdf');

        $options = [
            'Document' => [
                'Bytes' => $file,
            ],
            'FeatureTypes' => ['FORMS'], // REQUIRED
        ];
        $result = $textract->analyzeDocument($options);

        //This could do with a lot more improvement!  For now I just want to make sure I get some kind of response.
        //We can worry about structure in the feature test.
        $this->assertTrue(is_object($result));
    }
}
