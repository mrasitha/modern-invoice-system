<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | INV-PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7fe; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; }
        .auth-card { width: 100%; max-width: 450px; padding: 40px; border: none; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); background: #fff; }
        .btn-primary { background: #4318ff; border: none; padding: 12px; border-radius: 12px; font-weight: 600; }
        .form-control { background: #f4f7fe; border: 1px solid transparent; padding: 12px 15px; border-radius: 12px; }
        .form-control:focus { background: #fff; border-color: #4318ff; box-shadow: none; }
        .error-text { color: #ea4335; font-size: 12px; margin-top: 5px; font-weight: 500; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Create Account</h3>
            <p class="text-muted small">Start managing your invoices professionally</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required>
                @error('name') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="mail@example.com" required>
                @error('email') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 characters" required>
                @error('password') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3 shadow">Sign Up</button>
            <p class="text-center small text-muted">Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Sign In</a></p>
        </form>
    </div>
</body>
</html>