@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold">Business Configuration</h3>
            <p class="text-muted small">Update your company details for invoices and documents.</p>
        </div>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <!-- <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                            <i class="bi bi-building fs-1 text-primary"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">Company Identity</h5>
                    <p class="text-muted small">This logo will appear on all generated PDFs.</p>
                    <input type="file" name="business_logo" class="form-control form-control-sm mt-3">
                </div> -->
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
                    <div class="mb-3 position-relative d-inline-block">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center shadow-sm overflow-hidden" style="width: 120px; height: 120px; margin: 0 auto;">
                            @if(isset($settings['business_logo']))
                                <img id="logo-preview" src="{{ asset('storage/' . $settings['business_logo']) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i id="logo-icon" class="bi bi-building fs-1 text-primary"></i>
                                <img id="logo-preview" src="#" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            @endif
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1">Company Logo</h6>
                    <p class="text-muted extra-small">Recommended: Square PNG/JPG</p>
                    
                    <input type="file" name="business_logo" id="logo-input" class="form-control form-control-sm mt-2" accept="image/*">
                </div>

            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>General Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Business Name</label>
                            <input type="text" name="business_name" class="form-control rounded-3" value="{{ $settings['business_name'] ?? '' }}" placeholder="Enter Company Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Business Email</label>
                            <input type="email" name="business_email" class="form-control rounded-3" value="{{ $settings['business_email'] ?? '' }}" placeholder="contact@company.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="business_phone" class="form-control rounded-3" value="{{ $settings['business_phone'] ?? '' }}" placeholder="+94 77 123 4567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tax / Registration No</label>
                            <input type="text" name="business_reg" class="form-control rounded-3" value="{{ $settings['business_reg'] ?? '' }}" placeholder="BRN-12345">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Address</label>
                            <textarea name="business_address" class="form-control rounded-3" rows="3">{{ $settings['business_address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-4"><i class="bi bi-bank me-2 text-success"></i>Payment Details (Footer Information)</h6>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Bank Details / Terms</label>
                            <textarea name="payment_terms" class="form-control rounded-3" rows="3" placeholder="Account Name: ... Bank: ... Branch: ...">{{ $settings['payment_terms'] ?? '' }}</textarea>
                            <small class="text-muted">This will be printed at the bottom of every Invoice/Quote.</small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm py-2 fw-bold">
                        <i class="bi bi-check2-circle me-2"></i> Save All Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    // Image Preview Script
    document.getElementById('logo-input').onchange = evt => {
        const [file] = evt.target.files;
        if (file) {
            const preview = document.getElementById('logo-preview');
            const icon = document.getElementById('logo-icon');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            if(icon) icon.style.display = 'none';
        }
    }
</script>
@endsection