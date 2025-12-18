@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Dashboard</h1>
        <p class="text-gray-600 mt-2">Ringkasan dan statistik aplikasi perekrutan</p>
    </div>
    
    <!-- Ringkasan Umum -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="group bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-2xl text-white"></i>
                    </div>
                </div>
                <div class="ml-5 flex-grow">
                    <p class="text-sm font-medium text-gray-600">Total Pelamar</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $total_applicants }}</p>
                </div>
            </div>
        </div>
        <div class="group bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-briefcase text-2xl text-white"></i>
                    </div>
                </div>
                <div class="ml-5 flex-grow">
                    <p class="text-sm font-medium text-gray-600">Total Lowongan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $total_jobs }}</p>
                </div>
            </div>
        </div>
        <div class="group bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-database text-2xl text-white"></i>
                    </div>
                </div>
                <div class="ml-5 flex-grow">
                    <p class="text-sm font-medium text-gray-600">Kandidat di Talent Pool</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $total_talent_pool }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Distribusi Status Pelamar</h2>
                <p class="text-sm text-gray-600 mt-1">Visualisasi status aplikasi kandidat</p>
            </div>
        </div>
        <div class="w-full h-80">
            <canvas id="statusDistributionChart"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('statusDistributionChart').getContext('2d');
            const statusData = JSON.parse('<?php echo json_encode($status_distribution); ?>');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData),
                    datasets: [{
                        label: 'Jumlah Pelamar',
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(100, 100, 100, 0.7)',
                            'rgba(200, 150, 50, 0.7)',
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        });
    </script>
@endsection
