@extends('admin.layout')
@section('title', 'Dashboard')
@section('dashboard-active', 'menu-active')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Major -->
        <div class="card bg-red-100 border-l-4 border-red-500 shadow-md">
            <div class="card-body">
                <h2 class="card-title text-red-600">Major</h2>
                <p class="text-3xl font-bold text-red-700">{{ $data_chart['kategori_temuan']->firstWhere('kategori_temuan','Major')?->jumlah ?? '-' }}</p>
                <p class="text-sm text-red-500">Jumlah temuan kategori major</p>
            </div>
        </div>

        <!-- Minor -->
        <div class="card bg-yellow-100 border-l-4 border-yellow-400 shadow-md">
            <div class="card-body">
                <h2 class="card-title text-yellow-600">Minor</h2>
                <p class="text-3xl font-bold text-yellow-700">{{ $data_chart['kategori_temuan']->firstWhere('kategori_temuan','Minor')?->jumlah ?? '-' }}</p>
                <p class="text-sm text-yellow-500">Jumlah temuan kategori minor</p>
            </div>
        </div>

        <!-- OFI -->
        <div class="card bg-green-100 border-l-4 border-green-500 shadow-md">
            <div class="card-body">
                <h2 class="card-title text-green-600">OFI</h2>
                <p class="text-3xl font-bold text-green-700">{{ $data_chart['kategori_temuan']->firstWhere('kategori_temuan','Ofi')?->jumlah ?? '-' }}</p>
                <p class="text-sm text-green-500">Jumlah temuan kategori OFI</p>
            </div>
        </div>

        <!-- Sesuai -->
        <div class="card bg-blue-100 border-l-4 border-blue-500 shadow-md">
            <div class="card-body">
                <h2 class="card-title text-blue-600">Sesuai</h2>
                <p class="text-3xl font-bold text-blue-700">{{ $data_chart['kategori_temuan']->firstWhere('kategori_temuan','Sesuai')?->jumlah ?? '-' }}</p>
                <p class="text-sm text-blue-500">Jumlah sesuai standar</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="flex flex-row flex-wrap">
                <div class="w-12/12">
                    <canvas id="myChart" class="w-full"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@php
    $chart=$data_chart['kategori_temuan_perbulan'];
    
@endphp
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                        label: 'Major',
                        data: @json($chart->firstWhere('kategori','Major')->data),
                        borderColor: '#ef4444',
                        backgroundColor: '#ef444480',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Minor',
                        data: @json($chart->firstWhere('kategori','Minor')->data),
                        borderColor: '#facc15',
                        backgroundColor: '#facc1580',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'OFI',
                        data: @json($chart->firstWhere('kategori','Ofi')->data),
                        borderColor: '#10b981',
                        backgroundColor: '#10b98180',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Sesuai',
                        data: @json($chart->firstWhere('kategori','Sesuai')->data),
                        borderColor: '#3b82f6',
                        backgroundColor: '#3b82f680',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Kategori Temuan per Bulan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Temuan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });
    </script>
@endpush
