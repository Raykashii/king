<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background-color: white;
            padding-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .sidebar-header {
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .sidebar-header h3 {
            color: #333;
            font-weight: 600;
        }
        .sidebar .nav-item {
            margin-bottom: 5px;
        }
        .sidebar .nav-link {
            color: #666;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 0 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #f0f7ff;
            color: #0d6efd;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .user-profile {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-top: auto;
            border-top: 1px solid #eee;
        }
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .user-profile .user-info {
            line-height: 1.2;
        }
        .user-profile .user-name {
            font-weight: 600;
            color: #333;
        }
        .user-profile .user-role {
            font-size: 12px;
            color: #888;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stats-card {
            padding: 20px;
            height: 100%;
        }
        .card-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .card-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0;
            color: #333;
        }
        .stats-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .stats-card.total {
            background-color: #fff;
            border-left: 5px solid #fd7e14;
        }
        .stats-card.total .icon {
            background-color: rgba(253, 126, 20, 0.1);
            color: #fd7e14;
        }
        .stats-card.paid {
            background-color: #fff;
            border-left: 5px solid #20c997;
        }
        .stats-card.paid .icon {
            background-color: rgba(32, 201, 151, 0.1);
            color: #20c997;
        }
        .stats-card.unpaid {
            background-color: #fff;
            border-left: 5px solid #6f42c1;
        }
        .stats-card.unpaid .icon {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }
        .stats-card.transfer {
            background-color: #fff;
            border-left: 5px solid #0dcaf0;
        }
        .stats-card.transfer .icon {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .search-box {
            position: relative;
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 10px 15px;
            padding-left: 40px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: white;
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-report {
            background-color: #20c997;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
        }
        .table-card {
            padding: 0;
        }
        .table-card .card-header {
            background-color: white;
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-card .table {
            margin-bottom: 0;
        }
        .table-card .table th {
            font-weight: 600;
            color: #666;
            border-top: none;
            padding: 15px 20px;
        }
        .table-card .table td {
            padding: 15px 20px;
            vertical-align: middle;
        }
        .badge {
            padding: 6px 12px;
            font-weight: 500;
            border-radius: 6px;
        }
        .badge-success {
            background-color: rgba(32, 201, 151, 0.1);
            color: #20c997;
        }
        .badge-warning {
            background-color: rgba(253, 126, 20, 0.1);
            color: #fd7e14;
        }
        .badge-primary {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }
        .btn-sm {
            padding: 5px 12px;
            font-size: 12px;
            border-radius: 6px;
        }
        /* Modal Styles */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid #eee;
            padding: 15px 20px;
        }
        .form-control, .form-select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #eee;
            margin-bottom: 15px;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            border-color: #0d6efd;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #555;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column vh-100">
        <div class="sidebar-header">
            <h3>Admin Panel</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.transactions') }}">
                    <i class="fas fa-exchange-alt"></i> Transactions
                </a>
            </li>
        </ul>
        
        <div class="user-profile mt-auto">
            <img src="/api/placeholder/40/40" alt="Admin">
            <div class="user-info">
                <div class="user-name">Admin</div>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="text-danger">
                    <small><i class="fas fa-sign-out-alt"></i> Logout</small>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Success alert for form submission -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="dashboard-header">
            <h2>Dashboard</h2>
            <div class="d-flex">
                <div class="search-box me-3">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search here...">
                </div>
                <button class="btn btn-report">
                    <i class="fas fa-file-download me-2"></i> Generate Report
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card stats-card total">
                    <div class="icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h6 class="card-title">Total Transaction</h6>
                    <h2 class="card-value">{{ $totalTransactions }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card paid">
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h6 class="card-title">Paid Transaction</h6>
                    <h2 class="card-value">{{ $completedTransactions }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card unpaid">
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h6 class="card-title">Unpaid Transaction</h6>
                    <h2 class="card-value">{{ $pendingTransactions }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card transfer">
                    <div class="icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h6 class="card-title">Total Transfers</h6>
                    <h2 class="card-value">{{ $transferTransactions }}</h2>
                </div>
            </div>
        </div>

        <!-- Users Data -->
        <div class="card table-card">
            <div class="card-header">
                <h5 class="m-0">Users Management</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-1"></i> Add User
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $index = 1; @endphp
                    
                        @foreach ($siswaUsers as $user)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $user->role }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editUserModal" 
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-role="{{ $user->role }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    
                        @foreach ($bankMiniUsers as $user)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $user->role }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editUserModal" 
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-role="{{ $user->role }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="siswa">Siswa</option>
                                <option value="bank_mini">Bank Mini</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" action="" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="siswa">Siswa</option>
                                <option value="bank_mini">Bank Mini</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <strong id="delete_user_name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteUserForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit User Modal
        const editUserModal = document.getElementById('editUserModal')
        if (editUserModal) {
            editUserModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const userId = button.getAttribute('data-user-id')
                const userName = button.getAttribute('data-user-name')
                const userEmail = button.getAttribute('data-user-email')
                const userRole = button.getAttribute('data-user-role')
                
                const form = document.getElementById('editUserForm')
                const nameInput = document.getElementById('edit_name')
                const emailInput = document.getElementById('edit_email')
                const roleSelect = document.getElementById('edit_role')
                
                form.action = `/admin/update/${userId}`
                nameInput.value = userName
                emailInput.value = userEmail
                roleSelect.value = userRole
            })
        }
        
        // Delete User Modal
        const deleteUserModal = document.getElementById('deleteUserModal')
        if (deleteUserModal) {
            deleteUserModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const userId = button.getAttribute('data-user-id')
                const userName = button.getAttribute('data-user-name')
                
                const userNameSpan = document.getElementById('delete_user_name')
                const form = document.getElementById('deleteUserForm')
                
                userNameSpan.textContent = userName
                form.action = `/admin/delete/${userId}`
            })
        }
    </script>
</body>
</html>