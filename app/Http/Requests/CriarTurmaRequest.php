<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarTurmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * application/vnd.ms-excel, text/csv
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file'
        ];
    }
}
