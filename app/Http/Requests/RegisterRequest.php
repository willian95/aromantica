<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|unique:users,email|email",
            "phone" => "required",
            "password" => "required|confirmed",
            "address" => "required",
            "identification" => "required|unique:users,identification"
        ];
    }

    public function messages(){

        return[
            "name.required" => "Nombre es requerido",
            "email.required" => "Email es requerido",
            "email.unique" => "Este email ya ha sido utilizado",
            "email.email" => "Formato de email no válido",
            "phone.required" => "Teléfono es requerido",
            "password.required" => "Contraseña es requerida",
            "password.confirmed" => "Contraseñas no coinciden",
            "address.required" => "Dirección es requerida",
            "identification.required" => "Cédula es requerida",
            "identification.unique" => "Cédula ya ha sido utilizada"
        ];

    }

}
