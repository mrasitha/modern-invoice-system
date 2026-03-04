@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Main Dashboard</h3>
        <button class="btn btn-primary rounded-pill px-4 shadow">
            <i class="bi bi-plus-lg me-2"></i>New Project
        </button>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary-subtle p-3 rounded-4 me-3">
                        <i class="bi bi-currency-dollar text-primary fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total Invoiced</p>
                        <h4 class="fw-bold mb-0">LKR 450k</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success-subtle p-3 rounded-4 me-3">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Paid Amount</p>
                        <h4 class="fw-bold mb-0">LKR 320k</h4>
                    </div>
                </div>
            </div>
        </div>
        </div>

    <div class="card mt-5 border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">Recent Invoices & Quotes</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Project Name</th>
                        <th>Type</th>
                        <th>Mode</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-semibold">E-Commerce Web App</td>
                        <td><span class="badge bg-info-subtle text-info rounded-pill">Quotation</span></td>
                        <td>Functional</td>
                        <td class="fw-bold">LKR 85,000</td>
                        <td><span class="badge bg-warning-subtle text-warning rounded-pill">Pending</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection