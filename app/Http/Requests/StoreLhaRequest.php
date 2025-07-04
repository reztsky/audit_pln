<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLhaRequest extends FormRequest
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
        return [
            'inserted_by'=>'required|numeric|exists:users,id',
            'id_kertas_kerja'=>'required|array|min:1',
            'id_kertas_kerja.*'=>'required|numeric|exists:kertas_kerjas,id',
            'action'=>'required'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'inserted_by'=>Auth::user()->id,
            'action'=>'diajukan'
        ]);
    }
}
