<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
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
            "email" => "required|email|unique:newsletters,email"
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Email es requerido",
            "email.email" => "Email no es válido",
            "email.unique" => "Este email ya existe"
        ];
    }
}
