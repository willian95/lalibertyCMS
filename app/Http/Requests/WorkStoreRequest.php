<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkStoreRequest extends FormRequest
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
            "image" => "required",
            "createdDate" => "required|date",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "Título es requerido",
            "clientName.required" => "Nombre del cliente es requerido",
            "createdDate.required" => "Fecha de creación es requerida",
            "createdDate.date" => "Debe ingresar una fecha válida",
        ];
    }
}
