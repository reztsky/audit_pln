@push('style')
@endpush
<dialog id="lihatTim" class="modal overflow-visible">
    <div class="modal-box md:modal-middle modal-bottom overflow-visible">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold mb-5 w-full text-left">Tim Audit</h3>
        @csrf
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 w-full">
            <table class="table" id="table-tim">
                <!-- head -->
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>PIC</th>
                    </tr>
                </thead>
                <tbody class="hidden" id="tim-skeleton">
                    <tr>
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                        <td>
                            <div class="skeleton h-4 w-auto"></div>
                        </td>
                        <td class="text-center">
                            <div class="skeleton h-6 w-auto mx-auto rounded-full"></div>
                        </td>
                    </tr>
                </tbody>
                <tbody id="tim-tbody" class="hidden">
                    
                </tbody>
            </table>
        </div>
    </div>
</dialog>
@push('script')
    <script>
        function setTbodyTim(data) {
            var role= @json(Auth::user()->roles->first()->name);
            var role_can_access=['Atasan Auditee','Super Admin']
            var tbody = ``;
            data.forEach(row => {
                tbody += `<tr>
                        <td>${row.pegawai.nip}</td>
                        <td>${row.pegawai.nama}</td>
                        <td>${row.pegawai.jabatan}</td>
                        <td>
                            <label class="label">
                                <input type="checkbox" ${row.is_pic==1 ? 'checked="checked"' : ''} ${role_can_access.includes(role) ? '' : 'disabled'} data-id="${row.id}" class="toggle toggle-success toggle-pic" />
                            </label>
                        </td>
                    </tr>`
            });
            return tbody
        }


        $('.btn-lihat-tim').on('click', function() {
            var id = $(this).data('id')
            var url = "{{ route('timAudit.timByPka', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#tim-skeleton').show()
                    $('#tim-tbody').hide()
                },
                success: function(resp) {
                    var data = resp.data
                    $('#tim-skeleton').hide()
                    $('#tim-tbody').html(setTbodyTim(data)).show()
                }
            })
        })

        $('#table-tim').on('click', '.toggle-pic', function() {
            const id = $(this).data('id');
            const isPic = this.checked ? 1 : 0;
            var url = "{{ route('timAudit.update', ':id') }}"
            url = url.replace(':id', id)
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        is_pic: isPic
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (!res.success) throw new Error('Gagal update.');
                    alert('Berhasil mengupdate PIC.');
                })
                .catch(err => {
                    alert('Gagal mengupdate PIC.');
                    this.checked = !this.checked;
                });
        })
    </script>
@endpush
