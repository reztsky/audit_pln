<?php

namespace App\Http\Requests\Pka;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePkaRequest extends FormRequest
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
            'id_surat_tugas'=>'required|numeric|exists:surat_tugas,id',
            'landasan_audit'=>'required',
            'tujuan_audit'=>'required',
            'sasaran_audit'=>'required',
            'lingkup_audit'=>'required',
            'gambaran_audit'=>'required',
            'data_awal'=>'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'inserted_by' => Auth::user()->id
        ]);
    }
}
