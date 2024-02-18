<?php

namespace Tests\Feature;

use App\Models\PDFChunks;
use App\Models\PDFContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AWSTextractTest extends TestCase
{
    //Changed my mind, gonna just do file uploads.  Why not? :)  Just means I'll need to test this using postman until I can wrap in a front end.
    /** @test
     * It can post valid data to the endpoint and store it in the database.
     */
    public function it_can_make_a_call_to_aws_and_parse_a_response(){
        $chunksBefore = PDFChunks::count();
        $storedBefore = PDFContent::count();
        $file = UploadedFile::fake()->createWithContent('test.pdf','Hello, this is a test PDF :)')->mimeType('application/pdf');
        $response = $this->post(route('pdf.convert'), [
            'pdf'=>$file
        ]);

        $response->assertOk();
        $this->assertTrue($chunksBefore < PDFChunks::count());
        $this->assertTrue($storedBefore < PDFChunks::count());
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
        $response = $this->post(route('pdf.convert'), [
            'pdf' => UploadedFile::fake()->createWithContent('test.txt','Hello, this is a test PDF in disguise!  I am actually a text file!')
        ]);

        //We could go into more depth here if needed. EG exactly the error code, etc.
        $response->assertSessionHasErrors();
    }


}
