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
        :root { 
            --sidebar-width: 260px; 
            --sidebar-collapsed-width: 80px;
            --primary-color: #4318ff; 
            --bg-light: #f4f7fe; 
            --sidebar-bg: #ffffff;
        }
        
        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Base Styles */
        .sidebar { 
            width: var(--sidebar-width); 
            height: 100vh; 
            position: fixed; 
            background: var(--sidebar-bg); 
            border-right: 1px solid #e3e8f7; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            z-index: 1050; 
            overflow: hidden;
        }

        /* Sidebar Collapsed State (Desktop) */
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .sidebar.collapsed .nav-text, .sidebar.collapsed .sidebar-header-text, .sidebar.collapsed .extra-small {
            display: none;
        }
        .sidebar.collapsed .nav-link { text-align: center; padding: 12px 0; }
        .sidebar.collapsed .nav-link i { margin-right: 0 !important; font-size: 1.2rem; }
        .sidebar.collapsed .sidebar-header { justify-content: center !important; padding: 20px 0 !important; }

        .main-content { margin-left: var(--sidebar-width); transition: all 0.3s ease; min-height: 100vh; }
        .main-content.expanded { margin-left: var(--sidebar-collapsed-width); }
        
        /* Top Bar - Color matched with Sidebar */
        .top-bar { 
            padding: 10px 20px; 
            z-index: 900; 
            background: var(--sidebar-bg); 
            border-bottom: 1px solid #e3e8f7;
        }

        /* Nav Links */
        .nav-link { 
            color: #8e98aa; 
            padding: 12px 15px; 
            border-radius: 12px; 
            margin-bottom: 8px; 
            font-weight: 500; 
            transition: 0.3s; 
            display: flex;
            align-items: center;
            border: 1px solid transparent; 
        }
        .nav-link:hover { background: #f4f7fe; color: var(--primary-color); }
        
        /* Active State with simple border-right */
        .nav-link.active { 
            background: #f4f7fe; 
            color: var(--primary-color); 
            font-weight: 700; 
            border-right: 4px solid var(--primary-color); /* Right side border */
        }

        /* Sidebar collapsed වූ විටත් border එක හරියට පෙනෙන්න */
        .sidebar.collapsed .nav-link i {
            margin: 5px;
        }

        /* Mobile Adjustments */
        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show { margin-left: 0; width: var(--sidebar-width); }
            .sidebar.show .nav-text { display: inline-block; }
            .main-content { margin-left: 0; }
            .sidebar.collapsed { margin-left: calc(-1 * var(--sidebar-width)); }
        }

        #sidebarCollapse { border: none; background: transparent; color: #1b2559; font-size: 22px; cursor: pointer; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 1040; }
        .sidebar-overlay.show { display: block; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar p-3" id="sidebar">
        <div class="sidebar-header d-flex align-items-center mb-5 mt-2 px-3">
            <i class="bi bi-lightning-charge-fill text-primary fs-3 me-2"></i>
            <span class="fw-bold fs-4 tracking-tight sidebar-header-text">INV-PRO</span>
        </div>

        <nav class="nav flex-column px-2">
            <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-fill me-2"></i> <span class="nav-text">Dashboard</span>
            </a>
            <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                <i class="bi bi-folder-fill me-2"></i> <span class="nav-text">Projects</span>
            </a>
            <a class="nav-link {{ request()->is('documents') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                <i class="bi bi-file-earmark-text-fill me-2"></i> <span class="nav-text">All Invoices</span>
            </a>
            <a class="nav-link {{ request()->is('documents/create') ? 'active' : '' }}" href="{{ route('documents.create') }}">
                <i class="bi bi-plus-circle-fill me-2"></i> <span class="nav-text">New Document</span>
            </a>

            <div class="mt-4 mb-2 px-3"><span class="text-uppercase text-muted extra-small fw-bold">Account</span></div>
            <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                <i class="bi bi-gear-fill me-2"></i> <span class="nav-text">Settings</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger mt-3">
                    <i class="bi bi-box-arrow-left me-2"></i> <span class="nav-text">Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content" id="mainContent">
        <div class="top-bar d-flex justify-content-between align-items-center sticky-top">
            <button id="sidebarCollapse">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="profile-area d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block">
                    <p class="mb-0 fw-bold small text-dark">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="mb-0 text-muted extra-small">Administrator</p>
                </div>
                <div class="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-bold" 
                         style="width: 40px; height: 40px; cursor: pointer;" data-bs-toggle="dropdown">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-left me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="p-4 p-md-5">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('sidebarOverlay');
        const collapseBtn = document.getElementById('sidebarCollapse');

        collapseBtn.addEventListener('click', () => {
            if (window.innerWidth > 992) {
                // Desktop Collapse logic
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                // Mobile Drawer logic
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>
</body>
</html>