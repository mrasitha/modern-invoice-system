@extends('layouts.app')

@section('content')
<style>
    /* Table responsive එක ඇතුළේ dropdown එක කැපෙන්නේ නැති වෙන්න */
    .table-responsive {
        overflow: visible !important; /* Mobile එකේදී table එක scroll වෙන්න ඕනේ නම් මේක වෙනස් කරන්න වෙනවා */
    }

    /* Dropdown එක අනිවාර්යයෙන්ම උඩින් පෙන්වන්න */
    .dropdown-menu {
        z-index: 9999 !important;
        position: absolute !important;
        /* Dropdown එක table එකේ දකුණු පැත්තට කැපෙනවා නම් මේක පාවිච්චි කරන්න */
        right: 0 !important; 
        left: auto !important;
    }

    /* Mobile view එකේදී විතරක් table එක scroll වෙන්න දීලා dropdown එක පෙන්වන ක්‍රමය */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto !important;
            display: block;
            width: 100%;
            padding-bottom: 100px; /* Dropdown එකට අවශ්‍ය ඉඩ පල්ලෙහයින් ලබා දෙයි */
        }
    }
</style>
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

    <div class="card border-0 shadow-sm rounded-4 mb-4 p-3">
        <form action="{{ route('documents.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 rounded-end-pill" placeholder="Search by Doc Number, Client or Project..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select rounded-pill">
                    <option value="">All Types</option>
                    <option value="invoice" {{ request('type') == 'invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="quotation" {{ request('type') == 'quotation' ? 'selected' : '' }}>Quotation</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100 rounded-pill">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('documents.index') }}" class="btn btn-light w-100 rounded-pill border">Reset</a>
            </div>
        </form>
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
                            @php
                                $statusColor = [
                                    'pending' => 'bg-warning-subtle text-warning',
                                    'paid' => 'bg-success-subtle text-success',
                                    'accepted' => 'bg-primary-subtle text-primary',
                                    'declined' => 'bg-danger-subtle text-danger'
                                ][$doc->status] ?? 'bg-light text-dark';
                            @endphp
                            <span class="badge {{ $statusColor }} border-0 rounded-pill px-3">{{ ucfirst($doc->status) }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                
                                @if($doc->type == 'quotation' && $doc->status != 'accepted')
                                <a href="{{ route('documents.convert', $doc->id) }}" 
                                class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 shadow-sm"
                                onclick="return confirm('Do you want to convert this Quotation to an Invoice?')">
                                    <i class="bi bi-arrow-repeat me-1"></i> Convert
                                </a>
                                @endif

                                <div class="dropdown">
                                    <!-- <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button> -->
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" 
                                            data-bs-toggle="dropdown" 
                                            data-bs-display="static"
                                            data-bs-boundary="viewport" 
                                            aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('documents.viewPdf', $doc->id) }}" target="_blank"><i class="bi bi-eye me-2 text-primary"></i> View PDF</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('documents.pdf', $doc->id) }}"><i class="bi bi-download me-2 text-secondary"></i> Download PDF</a></li>
                                        
                                        @if($doc->type == 'invoice' && $doc->status != 'paid')
                                        <li><a class="dropdown-item py-2 text-success" href="{{ route('documents.updateStatus', [$doc->id, 'paid']) }}"><i class="bi bi-check-circle me-2"></i> Mark as Paid</a></li>
                                        @endif
                                        
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-file-earmark-x fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted">No documents found matching your criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection