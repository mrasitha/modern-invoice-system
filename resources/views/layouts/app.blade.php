<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INV-PRO | Business Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --sidebar-width: 260px; --primary-color: #4318ff; --bg-light: #f4f7fe; }
        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styles */
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e3e8f7; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); z-index: 1000; }
        .main-content { margin-left: var(--sidebar-width); transition: all 0.3s ease; min-height: 100vh; }
        
        /* Top Bar */
        .top-bar { padding: 15px 30px; z-index: 900; background: rgba(244, 247, 254, 0.7); backdrop-filter: blur(8px); }

        /* Sidebar Links */
        .nav-link { color: #8e98aa; padding: 12px 20px; border-radius: 12px; margin-bottom: 8px; font-weight: 500; transition: 0.3s; border: 1px solid transparent; }
        .nav-link:hover { background: #f4f7fe; color: var(--primary-color); }
        .nav-link.active { background: var(--primary-color); color: #fff; box-shadow: 0 10px 20px rgba(67, 24, 255, 0.15); }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
        }

        .extra-small { font-size: 11px; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    </style>
</head>
<body>

    <div class="sidebar p-3" id="sidebar">
        <div class="d-flex align-items-center mb-5 mt-2 px-3">
            <i class="bi bi-lightning-charge-fill text-primary fs-3 me-2"></i>
            <span class="fw-bold fs-4 tracking-tight">INV-PRO</span>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-fill me-2"></i> Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                <i class="bi bi-folder-fill me-2"></i> Projects
            </a>

            <a class="nav-link {{ request()->routeIs('documents.index') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                <i class="bi bi-file-earmark-text-fill me-2"></i> All Invoices
            </a>

            <a class="nav-link {{ request()->routeIs('documents.create') ? 'active' : '' }}" href="{{ route('documents.create') }}">
                <i class="bi bi-plus-circle-fill me-2"></i> New Document
            </a>

            <div class="mt-4 mb-2 px-3">
                <span class="text-uppercase text-muted extra-small fw-bold">Account</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger">
                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center sticky-top">
            <button class="btn btn-white border shadow-sm d-lg-none" id="sidebarCollapse">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="search-bar d-none d-md-block flex-grow-1 mx-4" style="max-width: 400px;">
                <div class="input-group bg-white rounded-pill px-3 py-1 shadow-sm border">
                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-0 shadow-none bg-transparent" placeholder="Search for projects or invoices...">
                </div>
            </div>

            <div class="profile-area d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block">
                    <p class="mb-0 fw-bold small text-dark">{{ Auth::user()->name ?? 'Guest User' }}</p>
                    <p class="mb-0 text-muted extra-small">Administrator</p>
                </div>
                <div class="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-bold cursor-pointer" 
                         style="width: 42px; height: 42px; cursor: pointer;" 
                         data-bs-toggle="dropdown">
                        {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="p-4 p-md-5">
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth Sidebar Toggle for Mobile
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('sidebarCollapse');

        collapseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992 && !sidebar.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>