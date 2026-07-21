@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class="container-fluid py-4">
        
        {{-- Statistics Cards - Data Riil Perpustakaan --}}
        <div class="row">
            {{-- Total Buku --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Buku</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $stats['total_books'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-books text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Anggota --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Anggota</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $stats['total_members'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Sedang Dipinjam</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $stats['dipinjam'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dikembalikan --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Dikembalikan</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $stats['dikembalikan'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts - GRID SEIMBANG SEJAJAR HORIZONTAL --}}
        <div class="row mt-4">
            {{-- Chart Statistik Peminjaman Bulanan - Sisi Kiri --}}
            <div class="col-md-7 mb-md-0 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Statistik Peminjaman Bulanan</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chartPeminjaman" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Donut Chart Status Peminjaman - Sisi Kanan --}}
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Status Peminjaman</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chartStatus" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Buku Terpopuler --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Buku Terpopuler (Paling Sering Dipinjam)</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Judul Buku</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Penulis</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Dipinjam</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Stok Tersedia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($popular_books as $book)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $book->judul }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $book->penulis }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">{{ $book->total_dipinjam }} kali</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $book->stok }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-sm py-3">
                                                <em class="text-secondary">Belum ada data peminjaman</em>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Peminjaman Bulanan (Line Chart)
    const ctxPeminjaman = document.getElementById('chartPeminjaman').getContext('2d');
    new Chart(ctxPeminjaman, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: {!! json_encode($chart_data) !!},
                backgroundColor: 'rgba(23, 162, 184, 0.8)',
                borderColor: 'rgba(23, 162, 184, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Donut Chart Status Peminjaman
    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Dipinjam', 'Dikembalikan'],
            datasets: [{
                data: [{{ $stats['dipinjam'] }}, {{ $stats['dikembalikan'] }}],
                backgroundColor: [
                    'rgba(251, 99, 64, 0.8)',
                    'rgba(94, 114, 228, 0.8)'
                ],
                borderColor: [
                    'rgba(251, 99, 64, 1)',
                    'rgba(94, 114, 228, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
