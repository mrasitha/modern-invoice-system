@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('projects.index') }}" class="text-decoration-none small text-muted"><i class="bi bi-arrow-left"></i> Back to Projects</a>
        <h2 class="fw-bold mt-2">{{ $project->name }}</h2>
        <p class="text-muted">Client: {{ $project->client_name }}</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Billing History</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-muted small">
                            <tr>
                                <th>DOC NUMBER</th>
                                <th>TYPE</th>
                                <th>BILLING</th>
                                <th>TOTAL</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->documents as $doc)
                            <tr>
                                <td class="fw-bold">{{ $doc->doc_number }}</td>
                                <td>
                                    <span class="badge {{ $doc->type == 'invoice' ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info' }} rounded-pill px-3">
                                        {{ ucfirst($doc->type) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ ucfirst($doc->billing_mode) }}
                                    @if($doc->billing_mode == 'functional')
                                        <i class="bi bi-layers text-secondary me-1"></i> Functional
                                    @else
                                        <i class="bi bi-briefcase text-secondary me-1"></i> Full Project
                                    @endif
                                </td>
                                <td class="fw-bold">LKR {{ number_format($doc->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border rounded-pill">{{ ucfirst($doc->status) }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu border-0 shadow-sm rounded-3">
                                            <li><a class="dropdown-content p-2 text-decoration-none text-dark d-block" href="#"><i class="bi bi-eye me-2"></i> View</a></li>
                                            
                                            @if($doc->type == 'quotation' && $doc->status == 'pending')
                                                <li><a class="dropdown-item text-primary" href="{{ route('documents.convert', $doc->id) }}"><i class="bi bi-arrow-repeat me-2"></i> Convert to Invoice</a></li>
                                            @endif

                                            @if($doc->status == 'pending')
                                                <li><a class="dropdown-item text-success" href="{{ route('documents.updateStatus', [$doc->id, 'paid']) }}"><i class="bi bi-check2-all me-2"></i> Mark as Paid</a></li>
                                            @endif

                                            <li>
                                                <a class="dropdown-item" href="{{ route('documents.pdf', $doc->id) }}">
                                                    <i class="bi bi-file-pdf me-2 text-danger"></i> Download PDF
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white text-center">
                <h6 class="opacity-75">Project Total Invoiced</h6>
                <h2 class="fw-bold">LKR {{ number_format($project->documents->sum('total_amount'), 2) }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection