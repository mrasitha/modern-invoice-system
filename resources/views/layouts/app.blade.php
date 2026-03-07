<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INV-PRO | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 260px; --primary-color: #4318ff; }
        body { background-color: #f4f7fe; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Sidebar Styles */
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e3e8f7; transition: all 0.3s; z-index: 1000; }
        .main-content { margin-left: var(--sidebar-width); transition: all 0.3s; min-height: 100vh; }
        
        /* Top Bar */
        .top-bar { background: rgba(244, 247, 254, 0.8); backdrop-filter: blur(10px); sticky: top; padding: 15px 30px; z-index: 900; }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
        }

        .nav-link { color: #8e98aa; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; font-weight: 500; }
        .nav-link.active { background: var(--primary-color); color: #fff; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    </style>
</head>
<body>

    <div class="sidebar p-3" id="sidebar">
        <div class="d-flex align-items-center mb-5 px-3">
            <i class="bi bi-lightning-charge-fill text-primary fs-3 me-2"></i>
            <span class="fw-bold fs-4">INV-PRO</span>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}"><i class="bi bi-folder-fill me-2"></i> Projects</a>
            <a class="nav-link {{ request()->routeIs('documents.create') ? 'active' : '' }}" href="{{ route('documents.create') }}"><i class="bi bi-file-earmark-plus-fill me-2"></i> New Document</a>
            <hr>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger">
                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <button class="btn btn-white border shadow-sm d-lg-none" id="sidebarCollapse">
                <i class="bi bi-list"></i>
            </button>
            <div class="search-bar d-none d-md-block">
                <div class="input-group bg-white rounded-pill px-3 py-1 shadow-sm">
                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Search invoices...">
                </div>
            </div>
            <div class="profile-area d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block">
                    <p class="mb-0 fw-bold small">{{ Auth::user()->name ?? 'Guest' }}</p>
                    <p class="mb-0 text-muted extra-small" style="font-size: 11px;">Admin Account</p>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px;">
                    {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                </div>
            </div>
        </div>

        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>