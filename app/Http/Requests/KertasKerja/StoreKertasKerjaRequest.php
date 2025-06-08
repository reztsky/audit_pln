<?php

namespace App\Http\Requests\KertasKerja;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreKertasKerjaRequest extends FormRequest
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
            'kontrol'=>'required',
            'unit'=>'required',
            'bidang'=>'required',
            'tanggal'=>'required|date|before:tomorrow',
            'temuan'=>'required',
            'ofi'=>'nullable',
            'keterangan_tambahan'=>'nullable',
            'dokumen_dukung'=>'nullable|file|max:10240|mimes:pdf,doc,docx',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'inserted_by'=>Auth::user()->id,
        ]);
    }
}
