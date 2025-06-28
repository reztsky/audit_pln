<dialog class="modal md:modal-middle modal-bottom" id="historyLha">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical text-sm animate-pulse hidden"
            id="history-skeleton">
            <li>
                <div class="timeline-middle">
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                </div>
                <div class="timeline-start mb-6 md:text-start space-y-1">
                    <div class="w-32 h-2 bg-gray-300 rounded"></div>
                    <div class="w-24 h-3 bg-gray-300 rounded"></div>
                    <div class="w-36 h-2 bg-gray-200 rounded"></div>
                </div>
                <hr />
            </li>
            <li>
                <div class="timeline-middle">
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                </div>
                <div class="timeline-end mb-6 md:text-start space-y-1">
                    <div class="w-32 h-2 bg-gray-300 rounded"></div>
                    <div class="w-24 h-3 bg-gray-300 rounded"></div>
                    <div class="w-36 h-2 bg-gray-200 rounded"></div>
                </div>
                <hr />
            </li>
        </ul>

        <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical text-sm hidden"
            id="history-lha">

        </ul>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@push('script')
    <script>
        $('.btn-history').on('click', function() {
            var id = $(this).data('id');
            var url = "{{ route('lha.lhaHistory', ':id') }}"
            url = url.replace(':id', id)

            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#history-skeleton').show()
                    $('#history-lha').hide()
                },
                success: function(resp) {
                    var data = resp.data
                    $('#history-lha').html(setHistory(data))
                    $('#history-skeleton').hide()
                    $('#history-lha').show()
                }
            })
        })

        function setHistory(data) {
            var timeline = ``
            data.forEach((row, i) => {
                timeline += `<li>
                    <div class="timeline-middle">
                        <x-heroicon-s-check-circle class="w-5 h-5" />
                    </div>
                    <div class="${i%2==0 ? 'timeline-start':'timeline-end'} mb-3 md:${i%2==0 ? 'text-end':'text-start'}">
                        <time class="font-mono italic">${row.formated_date} WIB</time>
                        <div class="text-md font-black">${row.formatedAction}</div>
                        <div class="text-sm font-medium">Oleh : ${row.user.name}</div>
                        ${row.catatan?? '-'}
                    </div>
                     <hr />
                </li>`
            });
            return timeline
        }
    </script>
@endpush
