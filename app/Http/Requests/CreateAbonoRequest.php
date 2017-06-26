<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CreateAbonoRequest extends FormRequest
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
            'dataInicial' => 'required',
            //'faltas_data_final' => 'required',
            'observacao' => 'required|max:100',
            'file' => 'required|mimetypes:application/pdf'
        ];
    }
    public function messages()
    {
        return [//         'observacao', 'arquivo', 'faltas_aluno_id', 'faltas_turma_id', , 'faltas_data','faltas_data_final', 'status'

            //'faltas_data_final.required' => 'O campo Endereço MAC é obrigatório',
            'dataInicial.required' => 'O campo Data é obrigatório',
            'observacao.required' => 'O campo Justificativa é obrigatório',
            'observacao.max' => 'A justificativa deve conter no máximo :max caracteres',
            'file.mimetypes' => 'O atestado deve ser do tipo PDF.',
            'file.uploaded' => 'Ocorreu uma falha durante o envio do atestado.',
        ];
    }
}
