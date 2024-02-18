<?php


namespace App\Services;
use Aws\Sdk;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TextractService
{

    private $textract;
    private $options;

    public function __construct()
    {
        $this->textract = App::make('aws')->createClient('textract');
        $this->options = $this->setDefaultOptions();
    }

    /**
     * Handles the API call to textract and stores the response in a document
     *
     * @param $file
     */
    public function MakeTextractAPICall($file){
       $this->addFileToDefaultOptions($file);
       try{
           $document = $this->textract->analyzeDocument($this->options);

           //Parse this into database

           //return good
       } catch (Throwable $t){
           report('Error: '.$t->getMessage());
       }
    }


    /**
     * Could probably move this to 'config' but for now, here's  fine.  We can write more methods if needed to manipulate
     * additional or different config into these options
     */
    private function setDefaultOptions(){
        $this->options = $options = [
            'Document' => [

            ],
            'FeatureTypes' => ['FORMS'], // REQUIRED
        ];
    }

    /**
     * This, for example, will add the file provided to the default options, we'll need to do this before we call the SDK
     * @param $file
     */
    public function addFileToDefaultOptions($file){
        $this->options['Documnet']['Bytes'] = $file;
    }

}
