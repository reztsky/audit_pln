@extends('admin.layout')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* Gaya dropdown secara umum */
        .ts-dropdown,
        .ts-dropdown .dropdown-content {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            /* gray-200 */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-color: white;
            font-size: 14px;
            padding: 0.25rem 0;
        }

        /* Opsi tiap item */
        .ts-dropdown .option {
            padding: 0.5rem 1rem;
            cursor: pointer;
            color: #374151;
            /* gray-700 */
            transition: background-color 0.2s ease;
        }

        .ts-dropdown .option:hover {
            background-color: #eff6ff;
            /* blue-50 */
        }

        .ts-dropdown .option.selected {
            background-color: #dbeafe;
            /* blue-100 */
            color: #1e3a8a;
            /* blue-800 */
        }

        /* Tampilan input utama */
        .ts-control {
            min-height: 42px;
            border: 1px solid #d1d5db;
            /* gray-300 */
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            font-size: 14px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Tag saat item dipilih */
        .ts-control .item {
            background-color: #dbeafe;
            /* blue-100 */
            color: #1e3a8a;
            /* blue-800 */
            border-radius: 9999px;
            padding: 0.25rem 0.5rem;
            font-size: 13px;
            margin-right: 0.25rem;
            font-weight: 500;
        }

        .ts-control .item .remove {
            margin-left: 0.25rem;
            color: #3b82f6;
            /* blue-500 */
            font-weight: bold;
            cursor: pointer;
        }

        .ts-control .item .remove:hover {
            color: #ef4444;
            /* red-500 */
        }
    </style>
@endpush
@section('title', 'Edit Laporan Hasil Audit (LHA)')
@section('lha-active', 'menu-active')
@section('content')
    @if ($errors->any())
        <div class="alert alert-error my-5">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card w-full bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="text-xl font-bold">{{ $pka->suratTugas->judul_audit }}</h2>
            <form action="{{ route('lha.update',$lha->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_pka" value="{{ $pka->id }}">
                <div class="flex flex-row flex-wrap">
                    <div class="md:w-6/12 w-12/12">
                        <div class="flex flex-row flex-wrap gap-y-5 p-5">
                            <div class="w-12/12">
                                <label class="floating-label">
                                    <span>Judul LHA</span>
                                    <input type="text" placeholder="Judul LHA" required
                                        class="input input-md w-full validator" name="judul" value="{{$lha->judul}}"/>
                                </label>
                            </div>
                            <div class="w-12/12">
                                <label class="floating-label">
                                    <span>Ringkasan</span>
                                    <textarea name="ringkasan" id="" class="textarea input-md h-[150px] w-full validator" required
                                        placeholder="Ringkasan">{{$lha->ringkasan}}</textarea>
                                </label>
                            </div>
                            <div class="w-12/12">
                                <label class="floating-label">
                                    <span>Tanggal Selesai</span>
                                    <input type="date" placeholder="Tanggal Selesai"
                                        class="input input-md w-full validator" name="tanggal" value="{{$lha->tanggal_selesai}}" />
                                    <p class="label">*Opsional</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-6/12 w-12/12 p-5 space-y-3">
                        <div class="w-12/12">
                            <h2 class="text-xl font-semibold mb-2">List Kertas Kerja</h2>
                            <ul class="list-disc ml-6">
                                @forelse($kertas_kerjas as $item)
                                    <li>{{ $item->kontrol }} - {{ Str::limit($item->temuan,75) ?? '-' }}</li>
                                @empty
                                    <li class="text-sm text-gray-500">Belum ada kertas kerja yang terhubung.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="w-12/12">
                            <label for="id_kertas_kerja">Assigment Kertas Kerja</label>
                            <select name="id_kertas_kerjas[]" id="id_kertas_kerja"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm text-sm mt-3"
                                multiple>

                                @forelse ($kertas_kerjas as $kertas_kerja)
                                    <option value="{{ $kertas_kerja->id }}" @selected(in_array($kertas_kerja->id,$lha->kertasKerja->pluck('id')->toArray()))>{{ $kertas_kerja->kontrol }} -
                                        {{ Str::limit($kertas_kerja->temuan, 50) }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-5">
                    <button class="btn btn-accent btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#id_kertas_kerja', {
            plugins: ['remove_button'],
            persist: false,
            create: false,
            placeholder: "Ketik untuk mencari...",
        })
    </script>
@endpush
