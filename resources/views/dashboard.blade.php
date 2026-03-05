@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Business Overview</h3>
        <a href="{{ route('documents.create') }}" class="btn btn-primary rounded-pill px-4 shadow">
            <i class="bi bi-plus-lg me-2"></i>New Document
        </a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <p class="opacity-75 small mb-1 text-uppercase fw-bold">Total Invoiced</p>
                    <h2 class="fw-bold">LKR {{ number_format($totalInvoiced, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm bg-white">
                <div class="card-body">
                    <p class="text-muted small mb-1 text-uppercase fw-bold text-success">Total Paid</p>
                    <h2 class="fw-bold">LKR {{ number_format($totalPaid, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm bg-white border-start border-warning border-5">
                <div class="card-body">
                    <p class="text-muted small mb-1 text-uppercase fw-bold">Pending Quotes</p>
                    <h2 class="fw-bold">{{ $pendingQuotes }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-dark">Recent Transactions</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light small text-muted">
                    <tr>
                        <th class="ps-4">PROJECT</th>
                        <th>TYPE</th>
                        <th>AMOUNT</th>
                        <th>STATUS</th>
                        <th class="text-end pe-4">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDocs as $doc)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold d-block">{{ $doc->project->name }}</span>
                            <small class="text-muted">No: {{ $doc->doc_number }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $doc->type == 'invoice' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info' }} rounded-pill">
                                {{ ucfirst($doc->type) }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark">LKR {{ number_format($doc->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border rounded-pill">{{ ucfirst($doc->status) }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-sm btn-outline-dark rounded-pill">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection