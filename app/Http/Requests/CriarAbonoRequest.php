<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarAbonoRequest extends FormRequest
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
            'arquivo' => 'required|file',
            'faltas_aluno_id' => 'required|exists:alunos,id',
            'faltas_turma_id' => 'required|exists:turmas,id',
            'faltas_data' => 'required|date_format:d/m/Y',
            'observacao' => 'required|max:255',
        ];
    }
}
