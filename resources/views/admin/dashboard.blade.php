@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Jumlah Mobil -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-car-front-fill" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-secondary mb-1">Jumlah Mobil</h5>
                        <p class="display-6 fw-bold mb-0">{{ $jumlahMobil }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Pesan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-chat-dots-fill" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-secondary mb-1">Jumlah Pesan</h5>
                        <p class="display-6 fw-bold mb-0">{{ $jumlahPesan }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Transaksi -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-danger text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-currency-dollar" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-secondary mb-1">Jumlah Transaksi</h5>
                        <p class="display-6 fw-bold mb-0">{{ $jumlahTransaksi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data dari Laravel
    const years = @json($years); // Tahun-tahun yang ada
    const months = @json($months); // Nama bulan
    const dataPerTahun = @json($dataPerTahun); // Data penjualan per tahun dan bulan

    // Persiapkan dataset untuk grafik
    const datasets = years.map(year => ({
        label: `Tahun ${year}`,
        data: dataPerTahun[year],
        fill: false, // Tidak mengisi area di bawah garis
        borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`, // Warna garis acak
        tension: 0.4, // Kelengkungan garis
        borderWidth: 2
    }));

    // Inisialisasi Chart.js
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line', // Tipe grafik garis
        data: {
            labels: months, // Nama bulan sebagai label sumbu X
            datasets: datasets // Dataset untuk setiap tahun
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Penjualan'
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

@endsection