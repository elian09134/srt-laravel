@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>
    
    <!-- Ringkasan Umum -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-blue-100 p-4 rounded-full"><i class="fas fa-users text-2xl text-blue-600"></i></div>
            <div class="ml-4">
                <p class="text-gray-500">Total Pelamar</p>
                <p class="text-3xl font-bold">{{ $total_applicants }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-green-100 p-4 rounded-full"><i class="fas fa-briefcase text-2xl text-green-600"></i></div>
            <div class="ml-4">
                <p class="text-gray-500">Total Lowongan</p>
                <p class="text-3xl font-bold">{{ $total_jobs }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-yellow-100 p-4 rounded-full"><i class="fas fa-database text-2xl text-yellow-600"></i></div>
            <div class="ml-4">
                <p class="text-gray-500">Kandidat di Talent Pool</p>
                <p class="text-3xl font-bold">{{ $total_talent_pool }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Distribusi Status Pelamar</h2>
        <div class="w-full h-80">
            <canvas id="statusDistributionChart"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('statusDistributionChart').getContext('2d');
            const statusData = @json($status_distribution);

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
