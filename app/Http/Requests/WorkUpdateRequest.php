<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkUpdateRequest extends FormRequest
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
            "title" => "required",
            "clientName" => "required",
            "description" => "required",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "Titulo es requerido",
            "clientName.required" => "Nombre del cliente es requerido",
            "description.required" => "Descipción es requerida",
        ];
    }
}
