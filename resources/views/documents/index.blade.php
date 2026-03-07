@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">All Documents</h2>
            <p class="text-muted">Manage all your quotations and invoices in one place.</p>
        </div>
        <a href="{{ route('documents.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Create New
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="text-muted small">
                    <tr>
                        <th>DOC NUMBER</th>
                        <th>PROJECT / CLIENT</th>
                        <th>TYPE</th>
                        <th>TOTAL AMOUNT</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td class="fw-bold text-primary">{{ $doc->doc_number }}</td>
                        <td>
                            <div class="fw-bold">{{ $doc->project->name }}</div>
                            <small class="text-muted">{{ $doc->project->client_name }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $doc->type == 'invoice' ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info' }} rounded-pill px-3">
                                {{ ucfirst($doc->type) }}
                            </span>
                        </td>
                        <td class="fw-bold">LKR {{ number_format($doc->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border rounded-pill px-3">{{ ucfirst($doc->status) }}</span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                    <li><a class="dropdown-item py-2" href="{{ route('documents.viewPdf', $doc->id) }}" target="_blank"><i class="bi bi-eye me-2 text-primary"></i> View PDF</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('documents.pdf', $doc->id) }}"><i class="bi bi-download me-2 text-secondary"></i> Download PDF</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-file-earmark-x fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted">No documents found. Start by creating one!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection