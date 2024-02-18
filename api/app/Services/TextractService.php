<?php


namespace App\Services;
use App\Models\PDFChunks;
use App\Models\PDFContent;
use Aws\Sdk;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
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
           These could really be config'd or similar to prevent us needing to extend/provide new ones in.  Perhaps even piped
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


    /**
     * Writes our stuff to the database! If it fails, nothing is written and we rollback to the previous point.
     *
     * @param $textractResponse
     * @param $filename
     */
    public function parseAndStoreDocumentChunks($textractResponse, $filename)
    {
        try {
            DB::beginTransaction();
            $pages = $textractResponse['DocumentMetadata']['Pages'];
            $content = PDFContent::create([
                'name' => $filename,
                'pages' => $pages
            ]);


            foreach ($textractResponse['Blocks'] as $block) {
                /**
                 * There are better ways to set up the relationships than saving the ID directly to them create field.
                 * Examples are the 'associate' method, but I'm on a strict timeline here! :)
                 */
                PDFChunks::create([
                    'p_d_f_contents_id' => $content->id,
                    'block_data' => json_encode($block),
                    'text' => $block['Text'] ? $block['Text'] : null,
                    'block_type' => $block['BlockType'],
                    'confidence' => $block['Confidence'],
                ]);

            }


        } catch (Throwable $t) {
            DB::rollBack();
            report($t->getMessage());
        }
        DB::commit();
    }


}
