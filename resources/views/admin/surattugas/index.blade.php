@extends('admin.layout')
@section('title', 'Surat Tugas')
@section('surattugas-active', 'menu-active')
@section('content')
    @hasanyrole(['Atasan Auditor','Super Admin'])
        <div class="flex justify-end mb-5">
            <button class="btn btn-sm btn-accent" onclick="create.showModal()">Tambah</button>
        </div>
    @endhasanyrole
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

    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>PIC Audit</th>
                    <th>Audit</th>
                    <th>Surat Tugas</th>
                    <th>Daftar Hadir Closing</th>
                    <th>Closing Meeting</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($surattugass as $surattugas)
                    <tr>
                        <td>{{ $surattugass->firstItem() + $loop->index }}</td>
                        <td>{{ $surattugas->pegawai->nama }}</td>
                        <td>
                            <p class="text-slate-800"><span class="font-bold">{{ $surattugas->judul_audit }}</span> -
                                {{ $surattugas->lokasi_audit }}</p>
                            <p class="text-slate-500 text-xs">{{ $surattugas->tanggal_audit->translatedFormat('d F Y') }}
                            </p>
                        </td>
                        <td>
                            <div class="tooltip tooltip-accent tooltip-right" data-tip="Lihat Document">
                                <a href="{{ asset('storage/surat_tugas/' . $surattugas->surat_tugas) }}" target="_blank">
                                    <button class="btn btn-ghost btn-xs"><x-heroicon-o-document-magnifying-glass
                                            class="w-5 h-5" /></button>
                                </a>
                            </div>
                        </td>
                        <td>

                            @if (in_array($surattugas->pka?->kertasKerja?->first()?->lha?->action, ['selesai']))
                                @php
                                    $daftar_hadir_closing = $surattugas->dokumenMeeting->firstWhere(
                                        'jenis_dokumen',
                                        'Daftar Hadir Closing',
                                    );
                                @endphp
                                @if ($daftar_hadir_closing?->count() > 0)
                                    <div class="tooltip tooltip-accent tooltip-left" data-tip="Lihat Document">
                                        <a href="{{ asset('storage/dokumen_meeting/' . $daftar_hadir_closing->path_dokumen) }}"
                                            target="_blank">
                                            <button class="btn btn-ghost btn-xs"><x-heroicon-o-document-magnifying-glass
                                                    class="w-5 h-5" /></button>
                                        </a>
                                    </div>
                                    @hasanyrole(['Staf Auditor','Super Admin'])
                                        <form action="{{ route('dokumenMeeting.delete', $daftar_hadir_closing->id) }}"
                                            method="post" class="form-delete inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-error text-white btn-delete"
                                                data-id="{{ $daftar_hadir_closing->id }}">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                        </form>
                                    @endhasanyrole
                                @else
                                    <div class="badge badge-soft badge-info">Dokumen Belum Diunggah</div>
                                    @hasanyrole(['Staf Auditor','Super Admin'])
                                        <button class="btn btn-sm btn-accent btn-upload"
                                            onclick="uploadDokumenMeeting.showModal()" data-id="{{ $surattugas->id }}"
                                            data-jenisdokumen="Daftar Hadir Closing">Upload</button>
                                    @endhasanyrole
                                @endif
                            @else
                                <div class="badge badge-soft badge-warning">Audit Belum Selesai</div>
                            @endif
                        </td>
                        <td>
                            @if (in_array($surattugas->pka?->kertasKerja?->first()?->lha?->action, ['selesai']))
                                @php
                                    $closing_meeting = $surattugas->dokumenMeeting->firstWhere(
                                        'jenis_dokumen',
                                        'Closing Meeting',
                                    );
                                @endphp
                                @if ($closing_meeting?->count() > 0)
                                    <div class="tooltip tooltip-accent tooltip-left" data-tip="Lihat Document">
                                        <a href="{{ asset('storage/dokumen_meeting/' . $closing_meeting->path_dokumen) }}"
                                            target="_blank">
                                            <button class="btn btn-ghost btn-xs"><x-heroicon-o-document-magnifying-glass
                                                    class="w-5 h-5" /></button>
                                        </a>
                                    </div>
                                    @hasanyrole(['Staf Auditor','Super Admin'])
                                        <form action="{{ route('dokumenMeeting.delete', $closing_meeting->id) }}"
                                            method="post" class="form-delete inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-error text-white btn-delete"
                                                data-id="{{ $closing_meeting->id }}"><x-heroicon-o-trash
                                                    class="w-5 h-5" /></button>
                                        </form>
                                    @endhasanyrole
                                @else
                                    <div class="badge badge-soft badge-info">Dokumen Belum Diunggah</div>
                                    @hasanyrole(['Staf Auditor','Super Admin'])
                                        <button class="btn btn-sm btn-accent btn-upload"
                                            onclick="uploadDokumenMeeting.showModal()" data-id="{{ $surattugas->id }}"
                                            data-jenisdokumen="Closing Meeting">Upload</button>
                                    @endhasanyrole
                                @endif
                            @else
                                <div class="badge badge-soft badge-warning">Audit Belum Selesai</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="99" class="text-center text-slate-500">No Found Record</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="my-4 px-3">
            {{ $surattugass->links() }}
        </div>
    </div>

    <dialog id="create" class="modal md:modal-middle modal-bottom ">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold mb-5">Tambah</h3>
            <form action="{{ route('suratTugas.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col flex-wrap gap-y-5">
                    <label class="floating-label ">
                        <span>PIC Staf Auditor</span>
                        <select name="pic_id_pegawai" id="" required class="select w-full validator">
                            <option value="" disabled selected>Pilih PIC Staf Auditor</option>
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama }} / <span
                                        class="text-slate-500">{{ $pegawai->nip }}</span> </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="floating-label">
                        <span>Judul Audit</span>
                        <input type="text" placeholder="Judul Audit" required name="judul_audit"
                            class="input input-md w-full validator" />
                    </label>
                    <label class="floating-label">
                        <span>Lokasi Audit</span>
                        <input type="text" placeholder="Lokasi Audit" required class="input input-md w-full validator"
                            name="lokasi_audit" />
                    </label>
                    <label class="floating-label">
                        <span>Tanggal Audit</span>
                        <input type="date" class="input input-md w-full validator" name="tanggal_audit" required>
                    </label>
                    <label class="floating-label">
                        <span>Surat Tugas</span>
                        <input type="file" class="menu-active file-input input-md w-full validator" name="surat_tugas"
                            accept="application/pdf" required>
                        <p class="label text-xs">Maks. File 2Mb</p>
                    </label>
                </div>
                <button type="submit" class="btn btn-accent btn-sm mt-3 w-full">Simpan</button>
            </form>
        </div>
    </dialog>

    @include('admin.surattugas.upload_dokumen')
@endsection

@push('script')
    <script>
        $('.form-delete').on('submit', function(e) {
            e.preventDefault()
            if (confirm('Yakin Ingin Menghapus Dokumen ? ')) {
                this.submit();
            }
        })
    </script>
@endpush
