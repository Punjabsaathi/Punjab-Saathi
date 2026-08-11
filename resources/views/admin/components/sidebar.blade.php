<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">

        <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">
                <i class="fa fa-user-edit me-2"></i>PSK Admin
            </h3>
        </a>
        <div class="navbar-nav w-100">

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <a href="#" class="nav-item nav-link">
                <i class="fa fa-envelope me-2"></i>Inquiries
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}"
                   data-bs-toggle="dropdown">
                    <i class="fa fa-blog me-2"></i>Blog
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin.blogs.index') }}" class="dropdown-item">All Posts</a>
                    <a href="{{ route('admin.blogs.create') }}" class="dropdown-item">Add New Post</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-cogs me-2"></i>Services
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="#" class="dropdown-item">All Services</a>
                    <a href="{{ route('admin.services.create') }}" class="dropdown-item">Add Service</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-project-diagram me-2"></i>Projects
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="#" class="dropdown-item">All Projects</a>
                    <a href="#" class="dropdown-item">Add Project</a>
                </div>
            </div>

            <a href="#" class="nav-item nav-link">
                <i class="fa fa-comments me-2"></i>Testimonials
            </a>

            <a href="#" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i>Users
            </a>

            <a href="#" class="nav-item nav-link">
                <i class="fa fa-cog me-2"></i>Settings
            </a>

            <hr class="text-white">

            <a href="#" class="nav-item nav-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt me-2"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
    </nav>
</div>