@extends('layouts.app')

@section('content')
<style>
    .metric-card { border: none; border-radius: 16px; background: #fff; transition: all 0.3s ease; border-left: 5px solid transparent; }
    .metric-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    
    /* Left Border Lines & Colors */
    .border-primary-line { border-left-color: #4318ff; }
    .border-success-line { border-left-color: #05cd99; }
    .border-warning-line { border-left-color: #ffb521; }
    .border-info-line { border-left-color: #01b9ff; }
    .border-danger-line { border-left-color: #ee5d50; }

    .icon-circle { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .text-xs { font-size: 0.75rem; }
    .chart-container { position: relative; height: 320px; width: 100%; }
</style>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-dark mb-1">Financial Intelligence</h3>
            <p class="text-muted small">Comprehensive summary of your business performance.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card metric-card border-primary-line shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill text-xs">Revenue</span>
                </div>
                <div class="row">
                    <div class="col-6 border-end">
                        <small class="text-muted d-block text-xs text-uppercase fw-bold">Tot Invoiced</small>
                        <span class="fw-bold text-dark">LKR {{ number_format($totalInvoiced, 0) }}</span>
                    </div>
                    <div class="col-6 ps-3">
                        <small class="text-muted d-block text-xs text-uppercase fw-bold">Tot Quotes</small>
                        <span class="fw-bold text-muted">LKR {{ number_format($totalQuotes, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card metric-card border-success-line shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="icon-circle bg-success bg-opacity-10 text-success">
                        <i class="bi bi-piggy-bank"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs">Growth</span>
                </div>
                <div class="row">
                    <div class="col-7 border-end">
                        <small class="text-muted d-block text-xs text-uppercase fw-bold">Est. Profit</small>
                        <span class="fw-bold text-success">LKR {{ number_format($estimatedProfit, 0) }}</span>
                    </div>
                    <div class="col-5 ps-3 text-center">
                        <small class="text-muted d-block text-xs text-uppercase fw-bold">Projects</small>
                        <span class="fw-bold text-dark">{{ $activeProjectsCount }} Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card metric-card border-warning-line shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill text-xs">Pending</span>
                </div>
                <div class="row">
                    <div class="col-6 border-end">
                        <small class="text-muted d-block text-xs text-uppercase fw-bold">Invoices</small>
                        <span class="fw-bold text-dark">{{ $pendingInvoicesCount }} Items</span>
                    </div>
                    <div class="col-6 ps-3">
                        <small class="text-muted d-block text-xs text-uppercase fw-bold">Quotations</small>
                        <span class="fw-bold text-dark">{{ $pendingQuotesCount }} Waiting</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Market Trend Analysis</h5>
                    <div class="btn-group btn-group-sm p-1 bg-light rounded-pill">
                        <button type="button" class="btn btn-white rounded-pill shadow-sm border-0 px-3 active" onclick="changeChart('line', this)">Line View</button>
                        <button type="button" class="btn btn-light rounded-pill border-0 px-3" onclick="changeChart('bar', this)">Bar View</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="mainBusinessChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let businessChart;
    const ctx = document.getElementById('mainBusinessChart').getContext('2d');

    const chartData = {
        labels: {!! json_encode($months) !!},
        datasets: [
            {
                label: 'Invoices (LKR)',
                data: {!! json_encode($invoiceData) !!},
                backgroundColor: 'rgba(67, 24, 255, 0.1)',
                borderColor: '#4318ff',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#4318ff'
            },
            {
                label: 'Quotations (LKR)',
                data: {!! json_encode($quoteData) !!},
                backgroundColor: 'rgba(5, 205, 153, 0.1)',
                borderColor: '#05cd99',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#05cd99'
            }
        ]
    };

    function renderChart(type = 'line') {
        if (businessChart) businessChart.destroy();
        businessChart = new Chart(ctx, {
            type: type,
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6 } }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { drawBorder: false, color: '#f8f9fa' },
                        ticks: { font: { size: 10 }, callback: v => 'LKR ' + (v >= 1000 ? v/1000 + 'k' : v) }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    function changeChart(type, btn) {
        // Handle Active Button UI
        const buttons = btn.parentElement.querySelectorAll('button');
        buttons.forEach(b => {
            b.classList.remove('active', 'btn-white', 'shadow-sm');
            b.classList.add('btn-light');
        });
        btn.classList.add('active', 'btn-white', 'shadow-sm');
        btn.classList.remove('btn-light');
        
        renderChart(type);
    }

    // Initialize on Load
    renderChart();
</script>
@endsection