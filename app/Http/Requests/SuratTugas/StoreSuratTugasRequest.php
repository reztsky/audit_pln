<?php

namespace App\Http\Requests\SuratTugas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSuratTugasRequest extends FormRequest
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
            'pic_id_pegawai'=>'required|numeric|exists:pegawais,id',
            'judul_audit'=>'required',
            'tanggal_audit'=>'required|date',
            'lokasi_audit'=>'required',
            'surat_tugas'=>'required|file|max:2048|mimes:pdf',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'inserted_by' => Auth::user()->id
        ]);
    }
}
