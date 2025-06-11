<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Admin
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('style')
</head>
</head>

<body class="bg-gray-100/40">
    <div class="drawer lg:drawer-open">
        <input id="sidebar" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <nav class="navbar bg-base-100 shadow-sm">
                <div class="flex-none">
                    <label for="sidebar" class="btn btn-square btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block h-5 w-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16">
                            </path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1">
                    <a class="text-xl font-bold">{{ config('app.name') }}</a>
                </div>
                <div class="flex-none">
                    <button class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block h-5 w-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                    </button>
                </div>
            </nav>
            <!-- Main Content -->
            <main class="flex-1 p-6 ">
                <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
                <div class="min-h-full">
                    @include('admin.notifikasi')
                    @yield('content')
                </div>
            </main>
        </div>


        <div class="drawer-side shadow">
            <label for="sidebar" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="menu bg-base-200 text-base-content min-h-full w-70 p-4 shadow">
                <div class="sticky top-0 flex flex-col">
                    <a href="" class="text-3xl font-bold">{{ config('app.name') }}</a>
                    <span class="text-xs text-left text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing
                        elit.</span>
                </div>
                <ul class="menu w-full text-base-content gap-y-1 p-0 pt-5">
                    <!-- Sidebar content here -->
                    <li><a><x-heroicon-o-home class="w-5 h-5" /> <span> Dashboard </span></a></li>
                    <li><a href="{{ route('suratTugas.index') }}" class="@yield('surattugas-active')"><x-heroicon-o-pencil-square
                                class="w-5 h-5" /><span>Surat Tugas</span></a></li>
                    <li><a href="{{ route('pka.index') }}" class="@yield('pka-active')"><x-heroicon-o-document-text class="w-5 h-5"/><span>PKA</span></a></li>
                    <li><a href="{{ route('kertasKerja.index') }}" class="@yield('kertaskerja-active')"><x-heroicon-o-paper-clip class="w-5 h-5"/><span>Kertas Kerja</span></a></li>
                    <li><a href="{{ route('lha.index') }}" class="@yield('lha-active')"><x-heroicon-o-flag class="w-5 h-5"/><span>Laporan Hasil Audit (LHA)</span></a></li>
                     <li><a href="{{ route('lhaReview.index') }}" class="@yield('lhareview-active')"><x-heroicon-o-presentation-chart-bar class="w-5 h-5"/><span>Review LHA</span></a></li>
                    <li>
                        <h2 class="menu-title">Master</h2>
                        <ul>
                            <li><a href="{{ route('pegawai.index') }}"
                                    class="@yield('pegawai-active')"><x-heroicon-o-user-group
                                        class="w-5 h-5" /><span>Pegawai</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@stack('script')

</html>
