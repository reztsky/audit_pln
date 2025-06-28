@if (session('notifikasi_sukses'))
    <div class="toast toast-top top-[8%] toast-end">
        <div class="alert alert-success">
            <span>{{ session('notifikasi_sukses') }}</span>
        </div>
    </div>
@endif

@if (session('notifikasi_gagal'))
    <div class="toast toast-top top-[8%] toast-end">
        <div class="alert alert-danger">
            {{ session('notifikasi_gagal')}}
        </div>
    </div>
@endif

@push('script')
    <script>
        $(document).ready(function(){
            setTimeout(() => {
                $('.toast').hide()
            }, 3000);
        })
    </script>
@endpush