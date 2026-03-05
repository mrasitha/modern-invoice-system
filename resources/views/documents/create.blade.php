@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('documents.store') }}" method="POST">
        @csrf
        <div class="card p-4 shadow-sm border-0">
            <h4 class="fw-bold mb-4">Generate New Document</h4>
            
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Select Project</label>
                    <select name="project_id" class="form-select border-0 bg-light p-3 rounded-4">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">Document Type</label>
                    <select name="type" class="form-select border-0 bg-light p-3 rounded-4">
                        <option value="quotation">Quotation</option>
                        <option value="invoice">Invoice</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">Billing Mode</label>
                    <select name="billing_mode" class="form-select border-0 bg-light p-3 rounded-4">
                        <option value="full">Full Project Payment</option>
                        <option value="functional">Functional Wise Payment</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-borderless" id="items-table">
                    <thead class="text-muted small">
                        <tr>
                            <th>DESCRIPTION</th>
                            <th width="150">QTY</th>
                            <th width="200">UNIT PRICE</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="items[0][desc]" class="form-control border-0 bg-light p-2" required></td>
                            <td><input type="number" name="items[0][qty]" class="form-control border-0 bg-light p-2 qty" value="1"></td>
                            <td><input type="number" name="items[0][price]" class="form-control border-0 bg-light p-2 price" placeholder="0.00"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <button type="button" class="btn btn-light text-primary fw-bold rounded-pill" onclick="addRow()">
                <i class="bi bi-plus-circle me-2"></i>Add Line
            </button>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill shadow">Generate & Save</button>
            </div>
        </div>
    </form>
</div>

<script>
    let rowIdx = 1;
    function addRow() {
        let table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        let row = table.insertRow();
        row.innerHTML = `
            <td><input type="text" name="items[${rowIdx}][desc]" class="form-control border-0 bg-light p-2" required></td>
            <td><input type="number" name="items[${rowIdx}][qty]" class="form-control border-0 bg-light p-2" value="1"></td>
            <td><input type="number" name="items[${rowIdx}][price]" class="form-control border-0 bg-light p-2" placeholder="0.00"></td>
            <td><button type="button" class="btn btn-link text-danger" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></td>
        `;
        rowIdx++;
    }
</script>
@endsection