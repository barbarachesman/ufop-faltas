<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GerenciarFaltaRequest extends FormRequest
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
            'turma'       => 'required|exists:turmas,id',
            'opcao'       => 'required|in:dia,intervalo',
            'dataInicial' => 'required|date_format:d/m/Y',
            'dataFinal'   => 'required_if:opcao,intervalo|date_format:d/m/Y'
        ];
    }
}
