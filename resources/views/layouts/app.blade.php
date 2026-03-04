<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Invoice System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 260px; }
        body { background-color: #f4f7fe; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e3e8f7; }
        .main-content { margin-left: var(--sidebar-width); padding: 30px; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .nav-link { color: #8e98aa; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; }
        .nav-link.active { background: #4318ff; color: #fff; }
        .nav-link:hover:not(.active) { background: #f4f7fe; }
    </style>
</head>
<body>
    <div class="sidebar p-3 d-none d-md-block">
        <div class="d-flex align-items-center mb-5 px-3">
            <i class="bi bi-lightning-charge-fill text-primary fs-3 me-2"></i>
            <span class="fw-bold fs-4">INV-PRO</span>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="/"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-folder-fill me-2"></i> Projects</a>
            <a class="nav-link" href="#"><i class="bi bi-file-earmark-text-fill me-2"></i> Invoices</a>
            <a class="nav-link" href="#"><i class="bi bi-gear-fill me-2"></i> Settings</a>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>