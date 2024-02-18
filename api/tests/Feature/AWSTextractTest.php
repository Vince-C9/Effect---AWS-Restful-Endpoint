<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AWSTextractTest extends TestCase
{
    /** @test
     * It can
     */
    public function it_can_fake_a_call_to_aws_and_parse_a_response(){
        Http::fake();
        $response = $this->post(route('pdf.convert'), [
            'pdf'=>'/pdf/sample.pdf'
        ]);

        $response->assertOk();
    }

    /**
     * @test
     * It won't allow a non-pdf file to get past the form request
     * We could use the storage faker here to creat the file as an uploaded file, similar to this:
     * UploadedFile::fake()->create('document.txt', 100);
     * we could then use that uploaded file to test if the invalid file type is caught.
     * To save time I've got one stored ready to test in the file structure - probably wouldn't usually do this!
     */
    public function it_doesnt_allow_invalid_files_past_the_request(){
        Http::fake();
        $response = $this->post(route('pdf.convert'), [
            'pdf'=>'/pdf/invalid.txt'
        ]);

        $response->assertSessionHasErrors();
    }

    /**
     * @test
     * It successfully saves the content of the PDF in the database
     */

     public function it_saves_the_data_to_the_database(){
        //flesh this one out shortly.
     }
}
