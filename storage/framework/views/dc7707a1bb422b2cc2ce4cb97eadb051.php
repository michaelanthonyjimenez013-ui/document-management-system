<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Malasakit DMS'); ?> - Document Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --light-color: #f1f5f9;
            --dark-color: #0f172a;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.3);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e293b;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        body.dark {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4f46e5 0%, #7c3aed 50%, #8b5cf6 100%);
            color: white;
            width: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-xl);
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 14px 24px;
            margin: 6px 12px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            overflow: hidden;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.3rem;
        }
        
        .sidebar.collapsed .nav-link-text {
            display: none;
        }
        
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: -18px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: 3px solid white;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1001;
            box-shadow: var(--shadow-lg);
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transform: scale(1.1);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 32px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }
        
        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            margin-bottom: 24px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }
        
        body.dark .card {
            background-color: rgba(30, 41, 59, 0.95);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
            color: #f1f5f9;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.dark .card-body {
            color: #f1f5f9;
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            font-weight: 600;
            padding: 20px 24px;
            color: #1e293b;
        }
        
        body.dark .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }
        
        body.dark a {
            color: #a5b4fc;
        }
        
        body.dark a:hover {
            color: #c7d2fe;
        }
        
        body.dark h1, body.dark h2, body.dark h3, body.dark h4, body.dark h5, body.dark h6 {
            color: #f1f5f9;
        }
        
        body.dark p, body.dark span, body.dark div, body.dark td, body.dark th {
            color: #f1f5f9;
        }
        
        body.dark .text-muted {
            color: #cbd5e1 !important;
        }
        
        body.dark .table {
            background-color: rgba(30, 41, 59, 1);
        }
        
        body.dark .table td, body.dark .table th {
            color: #f1f5f9 !important;
            border-color: rgba(255, 255, 255, 0.15);
        }
        
        body.dark .table thead {
            background-color: rgba(15, 23, 42, 1);
        }
        
        body.dark .table thead th {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.15);
        }
        
        body.dark .table tbody tr {
            background-color: rgba(30, 41, 59, 0.95);
        }
        
        body.dark .table tbody tr:nth-child(even) {
            background-color: rgba(41, 55, 75, 0.95);
        }
        
        body.dark .table-hover tbody tr:hover {
            background-color: rgba(51, 65, 85, 0.95) !important;
        }
        
        body.dark .table a {
            color: #93c5fd !important;
        }
        
        body.dark .table a:hover {
            color: #bfdbfe !important;
        }
        
        body.dark .table-responsive {
            background-color: rgba(30, 41, 59, 1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.dark .pagination .page-link {
            background-color: rgba(30, 41, 59, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        
        body.dark .pagination .page-link:hover {
            background-color: rgba(99, 102, 241, 0.3);
            border-color: rgba(99, 102, 241, 0.5);
        }
        
        body.dark .pagination .page-item.active .page-link {
            background-color: #6366f1;
            border-color: #6366f1;
            color: white;
        }
        
        body.dark .border-bottom {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark .border-top {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark .border {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark .btn-outline-primary {
            color: #a5b4fc;
            border-color: #6366f1;
        }
        
        body.dark .btn-outline-primary:hover {
            background-color: #6366f1;
            color: white;
        }
        
        body.dark .btn-outline-secondary {
            color: #cbd5e1;
            border-color: #64748b;
        }
        
        body.dark .btn-outline-secondary:hover {
            background-color: #64748b;
            color: white;
        }
        
        body.dark .btn-outline-danger {
            color: #fca5a5;
            border-color: #ef4444;
        }
        
        body.dark .btn-outline-danger:hover {
            background-color: #ef4444;
            color: white;
        }
        
        body.dark .btn-outline-info {
            color: #67e8f9;
            border-color: #06b6d4;
        }
        
        body.dark .btn-outline-info:hover {
            background-color: #06b6d4;
            color: white;
        }
        
        body.dark .btn-outline-success {
            color: #86efac;
            border-color: #10b981;
        }
        
        body.dark .btn-outline-success:hover {
            background-color: #10b981;
            color: white;
        }
        
        body.dark .btn-outline-dark {
            color: #e2e8f0;
            border-color: #475569;
        }
        
        body.dark .btn-outline-dark:hover {
            background-color: #475569;
            color: white;
        }
        
        body.dark .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        
        body.dark .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        body.dark .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        body.dark .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        body.dark .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }
        
        body.dark .badge {
            background-color: rgba(99, 102, 241, 0.3);
            color: #e0e7ff;
            border: 1px solid rgba(99, 102, 241, 0.4);
        }
        
        body.dark .badge.bg-success {
            background-color: rgba(16, 185, 129, 0.3);
            color: #bbf7d0;
            border: 1px solid rgba(16, 185, 129, 0.5);
        }
        
        body.dark .badge.bg-warning {
            background-color: rgba(245, 158, 11, 0.3);
            color: #fde68a;
            border: 1px solid rgba(245, 158, 11, 0.5);
        }
        
        body.dark .badge.bg-danger {
            background-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.5);
        }
        
        body.dark .badge.bg-info {
            background-color: rgba(6, 182, 212, 0.3);
            color: #a5f3fc;
            border: 1px solid rgba(6, 182, 212, 0.5);
        }
        
        body.dark .badge.bg-secondary {
            background-color: rgba(100, 116, 139, 0.3);
            color: #cbd5e1;
            border: 1px solid rgba(100, 116, 139, 0.5);
        }
        
        body.dark .alert {
            background-color: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        
        body.dark .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
            color: #86efac;
        }
        
        body.dark .alert-danger {
            background-color: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }
        
        body.dark .alert-warning {
            background-color: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fcd34d;
        }
        
        body.dark .alert-info {
            background-color: rgba(6, 182, 212, 0.15);
            border-color: rgba(6, 182, 212, 0.3);
            color: #67e8f9;
        }
        
        body.dark .input-group-text {
            background-color: rgba(30, 41, 59, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        
        body.dark .form-label {
            color: #f1f5f9;
        }
        
        body.dark .form-check-input {
            background-color: rgba(30, 41, 59, 0.8);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        body.dark .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        
        body.dark .form-check-label {
            color: #e2e8f0;
        }
        
        .stat-card {
            border-radius: 16px;
            padding: 24px;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }
        
        .stat-card.primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        
        .stat-card.success {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        
        .stat-card.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }
        
        .stat-card.info {
            background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
        }
        
        .stat-card .stat-icon {
            font-size: 2.8rem;
            opacity: 0.9;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }
        
        .stat-card .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 12px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card .stat-label {
            font-size: 0.95rem;
            opacity: 0.95;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table thead {
            background-color: #f8f9fa;
        }
        
        body.dark .table {
            color: #f8f9fa;
        }
        
        body.dark .table thead {
            background-color: rgba(15, 23, 42, 0.95);
        }
        
        body.dark .table tbody tr {
            background-color: rgba(30, 41, 59, 0.6);
            border-color: rgba(255, 255, 255, 0.05);
        }
        
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, var(--success-color) 100%);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            border: none;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, var(--danger-color) 100%);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            background: white;
        }
        
        body.dark .form-control,
        body.dark .form-select {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }
        
        body.dark .form-control:focus,
        body.dark .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
            background: rgba(30, 41, 59, 0.9);
        }
        
        body.dark .form-control::placeholder {
            color: #94a3b8;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            font-weight: 500;
        }
        
        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        
        .page-header {
            margin-bottom: 32px;
        }
        
        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }
        
        .page-header .breadcrumb {
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        h1, h2, h3, h4, h5, h6 {
            letter-spacing: -0.02em;
            font-weight: 700;
        }
        
        .table {
            border-radius: 12px;
            overflow: hidden;
            font-size: 0.95rem;
        }
        
        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            padding: 16px;
        }
        
        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
        }
        
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border: none;
            background-color: white;
        }
        
        body.dark .dropdown-menu {
            background-color: #16213e;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
            color: #212529;
        }
        
        body.dark .dropdown-item {
            color: #f8f9fa;
        }
        
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
        
        body.dark .dropdown-item:hover {
            background-color: #2d3a59;
        }
        
        .dropdown-item i {
            margin-right: 10px;
        }
        
        .sidebar-logo {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .sidebar-logo {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .main-content.collapsed {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?php if(auth()->guard()->check()): ?>
    <div id="sidebar" class="sidebar p-0">
        <button id="sidebarToggle" class="sidebar-toggle" title="Toggle Sidebar">
            <i class="bi bi-chevron-double-left"></i>
        </button>
        <div class="p-4 border-bottom border-secondary">
            <div class="sidebar-logo d-flex align-items-center justify-content-center">
                <img src="<?php echo e(asset('images/images__1_-removebg-preview.png')); ?>" alt="Malasakit DMS Logo" class="sidebar-logo-img" style="height: 60px; width: auto;">
            </div>
        </div>
        
        <nav class="nav flex-column mt-3">
            <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-speedometer2"></i>
                <span class="nav-link-text">Dashboard</span>
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('patients.*') ? 'active' : ''); ?>" href="<?php echo e(route('patients.index')); ?>">
                <i class="bi bi-people"></i>
                <span class="nav-link-text">Patients</span>
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('assessments.*') ? 'active' : ''); ?>" href="<?php echo e(route('assessments.index')); ?>">
                <i class="bi bi-clipboard-data"></i>
                <span class="nav-link-text">Assessments</span>
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('documents.*') ? 'active' : ''); ?>" href="<?php echo e(route('documents.index')); ?>">
                <i class="bi bi-file-earmark"></i>
                <span class="nav-link-text">Documents</span>
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>" href="<?php echo e(route('reports.index')); ?>">
                <i class="bi bi-graph-up"></i>
                <span class="nav-link-text">Reports</span>
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('import.*') ? 'active' : ''); ?>" href="<?php echo e(route('import.index')); ?>">
                <i class="bi bi-upload"></i>
                <span class="nav-link-text">Import</span>
            </a>
            
            <?php if(auth()->user()->isAdmin()): ?>
            <a class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                <i class="bi bi-person-gear"></i>
                <span class="nav-link-text">Users</span>
            </a>
            <a class="nav-link <?php echo e(request()->routeIs('audit-logs.index') ? 'active' : ''); ?>" href="<?php echo e(route('audit-logs.index')); ?>">
                <i class="bi bi-clock-history"></i>
                <span class="nav-link-text">Audit Logs</span>
            </a>
            <?php endif; ?>
            
            <a class="nav-link <?php echo e(request()->routeIs('users.edit', auth()->user()) ? 'active' : ''); ?>" href="<?php echo e(route('users.edit', auth()->user())); ?>">
                <i class="bi bi-gear"></i>
                <span class="nav-link-text">Settings</span>
            </a>
        </nav>
    </div>
    
    <div id="mainContent" class="main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <form action="<?php echo e(route('search')); ?>" method="GET" class="d-flex">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="query" class="form-control" placeholder="Search..." value="<?php echo e(request('query')); ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <button id="themeToggle" class="btn btn-outline-secondary" title="Toggle Theme">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </button>
                <div class="dropdown">
                    <div class="d-flex align-items-center gap-3" data-bs-toggle="dropdown" style="cursor: pointer;">
                        <div class="text-end">
                            <div class="fw-bold"><?php echo e(auth()->user()->name); ?></div>
                            <small class="text-muted"><?php echo e(ucfirst(auth()->user()->role)); ?></small>
                        </div>
                        <div class="user-avatar">
                            <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('users.show', auth()->user())); ?>"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('users.edit', auth()->user())); ?>"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
                
        
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Error:</strong> Please check the form for errors.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
       
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php else: ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const toggleIcon = sidebarToggle.querySelector('i');
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                
                if (sidebar.classList.contains('collapsed')) {
                    toggleIcon.classList.remove('bi-chevron-double-left');
                    toggleIcon.classList.add('bi-chevron-double-right');
                } else {
                    toggleIcon.classList.remove('bi-chevron-double-right');
                    toggleIcon.classList.add('bi-chevron-double-left');
                }
            });
            
            
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark');
                themeIcon.classList.remove('bi-moon-stars');
                themeIcon.classList.add('bi-sun');
            }
            
            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark');
                const isDark = document.body.classList.contains('dark');
                if (isDark) {
                    themeIcon.classList.remove('bi-moon-stars');
                    themeIcon.classList.add('bi-sun');
                    localStorage.setItem('theme', 'dark');
                } else {
                    themeIcon.classList.remove('bi-sun');
                    themeIcon.classList.add('bi-moon-stars');
                    localStorage.setItem('theme', 'light');
                }
            });
        });
    </script>
    
    
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="logoutModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        body.dark .modal-content {
            background-color: #16213e;
            color: #f8f9fa;
        }
        body.dark .modal-header,
        body.dark .modal-footer {
            border-color: #2d3a59;
        }
        body.dark .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\document-management-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>