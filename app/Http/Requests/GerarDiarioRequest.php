<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GerarDiarioRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'dataInicial' => 'required|date_format:d/m/Y',
            'dataFinal'   => 'required:opcao,intervalo|date_format:d/m/Y',
            'dias[]'      => 'array|in:0,1,2,3,4,5,6'
        ];
    }
}
