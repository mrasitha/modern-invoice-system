@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Project Management</h3>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addProjectModal">
            <i class="bi bi-plus-lg me-2"></i>New Project
        </button>
    </div>

    <div class="row g-4">
        @foreach($projects as $project)
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm rounded-4 position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $project->name }}</h5>
                            <p class="text-muted small mb-3"><i class="bi bi-person me-1"></i> {{ $project->client_name }}</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $project->documents_count }} Docs</span>
                    </div>
                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-light w-100 rounded-pill">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('projects.store') }}" method="POST" class="modal-content border-0 rounded-4">
            @csrf
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Project Name</label>
                    <input type="text" name="name" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Ex: E-commerce Site" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Client Name</label>
                    <input type="text" name="client_name" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Ex: Mr. Kamal" required>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Save Project</button>
            </div>
        </form>
    </div>
</div>
@endsection