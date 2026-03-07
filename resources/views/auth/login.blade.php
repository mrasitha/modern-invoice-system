<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | INV-PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7fe; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { width: 100%; max-width: 400px; padding: 40px; border: none; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); background: #fff; }
        .btn-primary { background: #4318ff; border: none; padding: 12px; border-radius: 12px; font-weight: 600; }
        .form-control { background: #f4f7fe; border: none; padding: 12px 15px; border-radius: 12px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Sign In</h3>
            <p class="text-muted small">Enter your email and password to login</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="mail@example.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
            <p class="text-center small text-muted">Not registered yet? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Create an account</a></p>
        </form>
    </div>
</body>
</html>