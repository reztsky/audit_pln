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
            'id_pka'=>'required|numeric|exists:pkas,id',
            'judul'=>'required',
            'ringkasan'=>'required',
            'tanggal_selesai'=>'nullable|date',
            'id_kertas_kerjas'=>'required|array|min:1',
            'id_kertas_kerjas.*'=>'required|numeric|exists:kertas_kerjas,id'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'inserted_by'=>Auth::user()->id
        ]);
    }
}
