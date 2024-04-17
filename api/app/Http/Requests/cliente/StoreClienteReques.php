<?php

namespace App\Http\Requests\cliente;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreClienteReques extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->id;
        return [
            'correo' =>
            [
                'required',
                'email',
                Rule::unique('clientes','correo')->ignore($id,'id')
            ],
            'name' =>'required|max:50',
            'identificacion' =>[
                'required',
                'max:50',
                Rule::unique('clientes','identificacion')->ignore($id,'id')
            ],
            'telefono' => 'required',
            'person_contact' => 'required',
            'pais' => 'required|max:100',
            // 'direccion' => 'required|',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'correo.required' => 'El campo email es obligatorio.',
            'correo.email' => 'El campo email debe ser una dirección de correo válida.',
            'correo.unique' => 'El campo email ya esta en uso.',
            'name.required' => 'El campo nombre es obligatorio.',
            'identificacion.required' => 'El campo identificación es obligatorio.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.person_contact' => 'El campo personal de contacto es obligatorio.',
            'telefono.pais' => 'El campo pais es obligatorio.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $dataResp=[
            "errors"=>$validator->errors(),
            "return"=>false
        ];
        throw new HttpResponseException(response()->json($dataResp, 422));
    }
}
