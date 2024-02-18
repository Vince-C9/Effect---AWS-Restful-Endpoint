<?php


namespace App\Services;
use App\Models\PDFContent;
use Aws\Sdk;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TextractService
{

    private $textract;

    public function __construct()
    {
        $this->textract = App::make('aws')->createClient('textract');
    }

    /**
     * Handles the API call to textract and stores the response in a document
     *
     * @param $file
     */
    public function makeTextractAPICall($file){
       try{

           /*
           These could reall be config'd or similar to prevent us needing to extend/provide new ones in.  Perhaps even piped
           in a s a parameter and having a bunch of presets could be a good option, depending on what configs we might need in
           our projects.
           */

           $options = [
               'Document' => [
                   'Bytes' => $file,
               ],
               'FeatureTypes' => ['FORMS'], // REQUIRED
           ];

           return $this->textract->analyzeDocument($options);
       } catch (Throwable $t){
           report('Error: '.$t->getMessage());
       }
    }



    public function parseAndStoreDocumentChunks($textractResponse, $filename){
        dd($textractResponse);
        $pages=$textractResponse['DocumentMetadata']['Pages'];
        $content = PDFContent::create([
            'name'=>$filename,
            'pages'=>$pages
        ]);


        foreach($textractResponse['Blocks'] as $block){

        }
    }




}
