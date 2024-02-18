<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PDFUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //Remember to change this when sanctum is wrapped in, or based on RBP's
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    /*We'd need one or two custom rules here to allow a B64 string to enter through the controller, however PDF uploads are supported!*/
    public function rules(): array
    {
        return [
            'pdf'=>'required|mimetypes:application/pdf|max:10000'
        ];
    }
}
