@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('documents.store') }}" method="POST">
        @csrf
        <div class="card p-4 shadow-sm border-0">
            <h4 class="fw-bold mb-4">Generate New Document</h4>
            
            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Select Project</label>
                    <select id="project_select" name="project_id" class="form-select border-0 bg-light p-3 rounded-4">
                        <option value="">Choose Project...</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8">
                    <div id="project_stats" class="p-3 rounded-4 bg-primary text-white shadow-sm d-none">
                        <div class="row text-center">
                            <div class="col-4 border-end border-white-50">
                                <small class="d-block opacity-75">Project Total</small>
                                <span id="stat_total" class="fw-bold">LKR 0</span>
                            </div>
                            <div class="col-4 border-end border-white-50">
                                <small class="d-block opacity-75">Paid</small>
                                <span id="stat_paid" class="fw-bold text-warning">LKR 0</span>
                            </div>
                            <div class="col-4">
                                <small class="d-block opacity-75">Balance Due</small>
                                <span id="stat_due" class="fw-bold">LKR 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <!-- <div class="col-md-4">
                    <label class="form-label small text-muted">Select Project</label>
                    <select name="project_id" class="form-select border-0 bg-light p-3 rounded-4">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div> -->
                <div class="col-md-6">
                    <label class="form-label small text-muted">Document Type</label>
                    <select name="type" class="form-select border-0 bg-light p-3 rounded-4">
                        <option value="quotation">Quotation</option>
                        <option value="invoice">Invoice</option>
                    </select>
                </div>
                <div class="col-md-6">
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

            <div class="row mt-5 pt-4 border-top">
                <div class="col-md-12 mb-4">
                    <h5 class="fw-bold text-dark"><i class="bi bi-info-circle me-2 text-primary"></i> Professional Details</h5>
                    <p class="text-muted small">These details will appear at the bottom of the invoice/quotation.</p>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label small text-muted fw-bold">RECURRING MONTHLY SERVICES (EDITABLE)</label>
                    <textarea name="recurring_services" class="form-control border-0 bg-light p-3 rounded-4" rows="3">
                        • Hosting & Maintenance: LKR 8,000 / month (DigitalOcean Droplet, Cloudflare, Backups)
                        • OTP Email API Service: LKR 3,000 / Month (Dedicated API Gateway)
                    </textarea>
                    <div class="form-text mt-2 small text-info"><i class="bi bi-lightbulb me-1"></i> You can change server/API costs per project here.</div>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label small text-muted fw-bold">TERMS AND CONDITIONS</label>
                    <textarea name="terms_and_conditions" class="form-control border-0 bg-light p-3 rounded-4" rows="5">
                        1. Project Handover: Full administrative access and source code will be transferred upon receipt of final payment.
                        2. Support: Includes 30 days of technical support for any bugs or system errors.
                        3. Payment Method: Please transfer the balance to the agreed bank account.
                        4. Validity: This quotation is valid for 14 days from the date of issuance.
                    </textarea>
                </div>
            </div>

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

    document.getElementById('project_select').addEventListener('change', function() {
        let projectId = this.value;
        let statsDiv = document.getElementById('project_stats');

        if (projectId) {
            // මෙතනදී ඔයාගේ Controller එකේ route එකකට ගිහින් data අරන් එනවා
            fetch(`/projects/${projectId}/stats`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text(); // මුලින්ම text එකක් විදිහට ගමු
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text); // දැන් parse කරමු
                        document.getElementById('stat_total').innerText = 'LKR ' + data.total;
                        document.getElementById('stat_paid').innerText = 'LKR ' + data.paid;
                        document.getElementById('stat_due').innerText = 'LKR ' + data.due;
                        statsDiv.classList.remove('d-none');
                    } catch (err) {
                        console.error('සර්වර් එකෙන් ආවේ JSON එකක් නෙවෙයි:', text);
                    }
                });
        } else {
            statsDiv.classList.add('d-none');
        }
    });
</script>
@endsection