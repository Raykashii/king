<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Banking Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6fa;
        }

        .nav-link {
            color: #6c757d;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .stats-card {
            height: 100px;
            width: 100%;
        }

        .wallet-card {
            background: linear-gradient(45deg, #4e54c8, #8089ff);
            color: white;
        }

        .transaction-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .transaction-item {
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .transaction-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
        }

        .transaction-item.deposit {
            border-left-color: #28a745;
        }

        .transaction-item.withdrawal {
            border-left-color: #dc3545;
        }

        .amount-btn {
            transition: all 0.3s ease;
        }

        .amount-btn.selected {
            background-color: #0d6efd !important;
            color: white !important;
            transform: scale(1.05);
        }

        .custom-amount::-webkit-inner-spin-button,
        .custom-amount::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Your existing dashboard content remains the same until the table actions -->
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-white p-3 min-vh-100">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="me-2">
                    <h4 class="mb-0">RapidCash</h4>
                </div>
                <div class="nav flex-column">
                    <a href="#" class="nav-link active" id="dashboardLink">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="#" class="nav-link" id="approvalLink">
                        <i class="fas fa-users me-2"></i> Approval
                    </a>
                    <a href="#" class="nav-link" id="transactionHistoryLink">
                        <i class="fas fa-history me-2"></i> Transaction History
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-alt me-2"></i> Table Siswa
                    </a>

                    <div class="mt-auto">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4" id="mainContent">
            <div class="row mb-4" id="dashboardContent">
    <!-- Stats Cards -->
    <div class="d-flex flex-row justify-content-between w-100">
        <div class="card stats-card" style="flex: 1; margin-right: 10px;">
            <div class="card-body">
                <h6 class="text-muted">Total Students</h6>
                <h3>{{ count($siswaUsers) }}</h3>
            </div>
        </div>
        <div class="card stats-card" style="flex: 1; margin-right: 10px;">
            <div class="card-body">
                <h6 class="text-muted">Active Accounts</h6>
                <h3>{{ count($siswaUsers) }}</h3>
            </div>
        </div>
        <div class="card stats-card" style="flex: 1; margin-right: 10px;">
            <div class="card-body">
                <h6 class="text-muted">Today's Transactions</h6>
                <h3>{{ $transactionCount }}</h3>
            </div>
        </div>
        <div class="card stats-card" style="flex: 1;">
            <div class="card-body">
                <h6 class="text-muted">Total Transfer Today</h6>
                <h3>${{ number_format($totalTransfers, 2) }}</h3> <!-- Display total transfer value -->
            </div>
        </div>
    </div>
</div>



                <div class="row">
                    <!-- Student Table -->
                    <div class="col-md-8 mb-4" id="studentContent">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Student Accounts</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Class</th>
                                                <th>Balance</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 1; @endphp
                                            @foreach ($siswaUsers as $student)
                                                <tr>
                                                    <td>{{ $index++ }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->class->name ?? 'N/A' }}</td>
                                                    <td>Rp {{ number_format($student->saldo, 0, ',', '.') }}</td>
                                                    <!-- Format as Rupiah -->
                                                    <td>
                                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#topUpModal"
                                                            data-student-id="{{ $student->id }}"
                                                            data-student-name="{{ $student->name }}">Top Up</button>
                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#withdrawModal"
                                                            data-student-id="{{ $student->id }}"
                                                            data-student-name="{{ $student->name }}">Withdraw</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($siswaUsers->isEmpty())
                                        <p class="text-center text-muted">No students available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Transaction History -->
                    <div class="col-md-4" id="transactionContent">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Today's Transactions</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="transaction-list">
                                    @forelse ($transactions as $transaction)
                                        <div
                                            class="transaction-item {{ $transaction->type === 'topup' ? 'deposit' : 'withdrawal' }} p-3 border-bottom">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="mb-1">
                                                        {{ $transaction->account ? $transaction->account->name : 'Unknown Account' }}
                                                    </h6>
                                                    <small class="text-muted">{{ ucfirst($transaction->type) }}</small>
                                                </div>
                                                <div
                                                    class="{{ $transaction->type === 'topup' ? 'text-success' : 'text-danger' }}">
                                                    {{ $transaction->type === 'topup' ? '+' : '-' }}Rp
                                                    {{ number_format($transaction->amount, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center text-muted p-3">No recent transactions.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Table Approval-->
                <div class="row mb-4" id="approvalContent" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Approval Requests</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Payment Method</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($topupRequests as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $request->account->name ?? 'No Name' }}</td>
                                                <td>{{ $request->type ?? 'N/A' }}</td>
                                                <td>Rp {{ number_format($request->amount, 0, ',', '.') }}</td>
                                                <td>{{ $request->status ?? 'Unknown' }}</td>
                                                <td>{{ $request->payment_method ?? 'N/A' }}</td>
                                                <td>{{ $request->description ?? 'No Description' }}</td>
                                                <td>
                                                    @if ($request->type === 'withdraw')
                                                        <a href="{{ route('approve.withdraw', $request->id) }}" class="btn btn-success btn-sm">Approve Withdraw</a>
                                                    @else
                                                        <a href="{{ route('approve.topup', $request->id) }}" class="btn btn-success btn-sm">Approve Top-up</a>
                                                    @endif
                                                    
                                                    <a href="{{ route('reject.topup', $request->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                    @if ($topupRequests->isEmpty())
                                        <p class="text-center text-muted">No requests available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                            <!-- Transaction History Table -->
                            <div class="row mb-4" id="transactionHistoryContent" style="display: none;">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="mb-0">Transaction History</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Date</th>
                                                            <th>Account Name</th>
                                                            <th>Transaction Type</th>
                                                            <th>Amount</th>
                                                            <th>Status</th>
                                                            <th>Payment Method</th> <!-- New Column -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $index = 1; @endphp
                                                        @foreach ($transactionHistory as $transaction)
                                                            <tr>
                                                                <td>{{ $index++ }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}
                                                                </td>
                                                                <td>{{ $transaction->account->name ?? 'Unknown Account' }}</td>
                                                                <td>{{ ucfirst($transaction->type) }}</td>
                                                                <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                                                <td>{{ ucfirst($transaction->status) }}</td>
                                                                <td>{{ $transaction->payment_method ?? 'N/A' }}</td>
                                                                <!-- Payment Method -->
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <!-- Table Users Content -->
                <div class="row mb-4" id="tableUsersContent" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Student Users</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createUserModal">
                                    <i class="fas fa-plus me-2"></i>Add New Student
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>

                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 1; @endphp
                                            @foreach ($siswaUsers as $student)
                                                <tr>
                                                    <td>{{ $index++ }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal"
                                                            data-student-id="{{ $student->id }}"
                                                            data-student-name="{{ $student->name }}"
                                                            data-student-email="{{ $student->email }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#deleteUserModal"
                                                            data-student-id="{{ $student->id }}"
                                                            data-student-name="{{ $student->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($siswaUsers->isEmpty())
                                        <p class="text-center text-muted">No students available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <!-- Top Up Modal -->
    <div class="modal fade" id="topUpModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Top Up Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="topUpForm" action="{{ route('bank_mini.topup', '') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" id="topUpStudentId">

                        <div class="mb-3">
                            <h6 class="text-muted">Student Name: <span id="topUpStudentName"></span></h6>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Select Amount</h5>
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary w-100 amount-btn"
                                        data-amount="10000">
                                        Rp 10.000
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary w-100 amount-btn"
                                        data-amount="50000">
                                        Rp 50.000
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary w-100 amount-btn"
                                        data-amount="100000">
                                        Rp 100.000
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary w-100 amount-btn"
                                        data-amount="250000">
                                        Rp 250.000
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customTopUpAmount" class="form-label">Custom Amount (Multiples of Rp
                                10.000)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control custom-amount" id="customTopUpAmount"
                                    name="amount" step="10000" min="10000">
                            </div>
                            <div class="form-text text-danger d-none" id="topUpAmountError">
                                Amount must be a multiple of Rp 10.000
                            </div>
                        </div>

                        <div class="mb-3">
                            <h5 class="mb-2">Total Amount</h5>
                            <div class="p-3 bg-light rounded">
                                <h3 class="text-primary mb-0" id="topUpTotalAmount">Rp 0</h3>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="topUpForm" class="btn btn-primary" id="confirmTopUpButton"
                        disabled>Confirm Top Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="withdrawForm" action="{{ route('bank_mini.withdraw', '') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" id="withdrawStudentId">

                        <div class="mb-3">
                            <h6 class="text-muted">Student Name: <span id="withdrawStudentName"></span></h6>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Select Amount</h5>
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-danger w-100 amount-btn"
                                        data-amount="10000">
                                        Rp 10.000
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-danger w-100 amount-btn"
                                        data-amount="50000">
                                        Rp 50.000
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-danger w-100 amount-btn"
                                        data-amount="100000">
                                        Rp 100.000
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-danger w-100 amount-btn"
                                        data-amount="250000">
                                        Rp 250.000
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customWithdrawAmount" class="form-label">Custom Amount (Multiples of Rp
                                10.000)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control custom-amount" id="customWithdrawAmount"
                                    name="amount" step="10000" min="10000">
                            </div>
                            <div class="form-text text-danger d-none" id="withdrawAmountError">
                                Amount must be a multiple of Rp 10.000
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-2">Total Amount</h5>
                            <div class="p-3 bg-light rounded">
                                <h3 class="text-danger mb-0" id="withdrawTotalAmount">Rp 0</h3>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="withdrawForm" class="btn btn-danger" id="confirmWithdrawButton"
                        disabled>Confirm Withdraw</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="siswa">

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createUserForm" class="btn btn-primary">Create Student</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="{{ route('users.update', '') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="student_id" id="editStudentId">

                        <div class="mb-3">
                            <label for="editName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="editPassword" class="form-label">New Password (leave blank to keep
                                current)</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUserForm" class="btn btn-warning">Update Student</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <span id="deleteStudentName"></span>?</p>
                    <form id="deleteUserForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="deleteStudentId" name="student_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="deleteUserForm" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal handling for Top Up
            const topUpModal = document.getElementById('topUpModal');
            const topUpForm = document.getElementById('topUpForm');
            const topUpStudentId = document.getElementById('topUpStudentId');
            const topUpStudentName = document.getElementById('topUpStudentName');
            const customTopUpAmount = document.getElementById('customTopUpAmount');
            const topUpTotalAmount = document.getElementById('topUpTotalAmount');
            const confirmTopUpButton = document.getElementById('confirmTopUpButton');
            const topUpAmountError = document.getElementById('topUpAmountError');

            // Modal handling for Withdraw
            const withdrawModal = document.getElementById('withdrawModal');
            const withdrawForm = document.getElementById('withdrawForm');
            const withdrawStudentId = document.getElementById('withdrawStudentId');
            const withdrawStudentName = document.getElementById('withdrawStudentName');
            const customWithdrawAmount = document.getElementById('customWithdrawAmount');
            const withdrawTotalAmount = document.getElementById('withdrawTotalAmount');
            const confirmWithdrawButton = document.getElementById('confirmWithdrawButton');
            const withdrawAmountError = document.getElementById('withdrawAmountError');

            // Format number to currency
            function formatCurrency(amount) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
            }

            [topUpForm, withdrawForm].forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const isTopUp = this.id === 'topUpForm';
                    const amount = parseInt(isTopUp ? customTopUpAmount.value : customWithdrawAmount
                        .value);

                    if (!isValidAmount(amount)) {
                        return;
                    }

                    // Update the form action with the correct student ID
                    if (isTopUp) {
                        const studentId = topUpStudentId.value;
                        this.action = "{{ route('bank_mini.topup', '') }}/" + studentId;
                    } else {
                        const studentId = withdrawStudentId.value;
                        this.action = "{{ route('bank_mini.withdraw', '') }}/" + studentId;
                    }

                    // Actually submit the form
                    this.submit();
                });
            });

            document.getElementById("approvalLink").addEventListener("click", function() {
                // Hide the dashboard, student, transaction, and transaction history content
                document.getElementById("dashboardContent").style.display = "none";
                document.getElementById("studentContent").style.display = "none";
                document.getElementById("transactionContent").style.display = "none";
                document.getElementById("transactionHistoryContent").style.display =
                    "none"; // Hide transaction history

                // Show the approval content
                document.getElementById("approvalContent").style.display = "block";

                // Update active state in the sidebar
                document.getElementById("dashboardLink").classList.remove("active");
                document.getElementById("approvalLink").classList.add("active");
            });

            document.getElementById("dashboardLink").addEventListener("click", function() {
                // Hide the approval and transaction content
                document.getElementById("approvalContent").style.display = "none";
                document.getElementById("transactionHistoryContent").style.display =
                    "none"; // Hide transaction history

                // Show the dashboard content and other sections
                document.getElementById("dashboardContent").style.display = "block";
                document.getElementById("studentContent").style.display = "block";
                document.getElementById("transactionContent").style.display = "block";

                // Update active state in the sidebar
                document.getElementById("approvalLink").classList.remove("active");
                document.getElementById("dashboardLink").classList.add("active");
            });

            document.getElementById("transactionHistoryLink").addEventListener("click", function() {
                // Hide the dashboard, student, and approval content
                document.getElementById("dashboardContent").style.display = "none";
                document.getElementById("studentContent").style.display = "none";
                document.getElementById("approvalContent").style.display = "none";
                document.getElementById("transactionContent").style.display = "none";

                // Show the transaction history content
                document.getElementById("transactionHistoryContent").style.display = "block";

                // Update active state in the sidebar
                document.getElementById("dashboardLink").classList.remove("active");
                document.getElementById("approvalLink").classList.remove("active");
                document.getElementById("transactionHistoryLink").classList.add("active");
            });



            // Validate amount is multiple of 10000
            function isValidAmount(amount) {
                return amount >= 10000 && amount % 10000 === 0;
            }

            // Handle amount button clicks for both modals
            document.querySelectorAll('.amount-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    const isTopUp = modal.id === 'topUpModal';

                    // Remove selected class from all buttons in this modal
                    modal.querySelectorAll('.amount-btn').forEach(btn => {
                        btn.classList.remove('selected');
                    });

                    // Add selected class to clicked button
                    this.classList.add('selected');

                    const amount = parseInt(this.dataset.amount);

                    // Update custom amount input
                    if (isTopUp) {
                        customTopUpAmount.value = amount;
                        topUpTotalAmount.textContent = formatCurrency(amount);
                        confirmTopUpButton.disabled = !isValidAmount(amount);
                        topUpAmountError.classList.add('d-none');
                    } else {
                        customWithdrawAmount.value = amount;
                        withdrawTotalAmount.textContent = formatCurrency(amount);
                        confirmWithdrawButton.disabled = !isValidAmount(amount);
                        withdrawAmountError.classList.add('d-none');
                    }
                });
            });

            // Handle custom amount input for both modals
            [customTopUpAmount, customWithdrawAmount].forEach(input => {
                input.addEventListener('input', function() {
                    const isTopUp = this.id === 'customTopUpAmount';
                    const amount = parseInt(this.value) || 0;
                    const isValid = isValidAmount(amount);

                    // Remove selected class from all buttons
                    const modal = this.closest('.modal');
                    modal.querySelectorAll('.amount-btn').forEach(btn => {
                        btn.classList.remove('selected');
                    });

                    if (isTopUp) {
                        topUpTotalAmount.textContent = formatCurrency(amount);
                        confirmTopUpButton.disabled = !isValid;
                        topUpAmountError.classList.toggle('d-none', isValid);
                    } else {
                        withdrawTotalAmount.textContent = formatCurrency(amount);
                        confirmWithdrawButton.disabled = !isValid;
                        withdrawAmountError.classList.toggle('d-none', isValid);
                    }
                });
            });

            // Modal show event handlers
            topUpModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const studentId = button.dataset.studentId;
                const studentName = button.dataset.studentName;

                topUpStudentId.value = studentId;
                topUpStudentName.textContent = studentName;

                // Reset form
                topUpForm.reset();
                topUpTotalAmount.textContent = 'Rp 0';
                confirmTopUpButton.disabled = true;
                topUpAmountError.classList.add('d-none');
                topUpModal.querySelectorAll('.amount-btn').forEach(btn => {
                    btn.classList.remove('selected');
                });
            });

            withdrawModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const studentId = button.dataset.studentId;
                const studentName = button.dataset.studentName;

                withdrawStudentId.value = studentId;
                withdrawStudentName.textContent = studentName;

                // Reset form
                withdrawForm.reset();
                withdrawTotalAmount.textContent = 'Rp 0';
                confirmWithdrawButton.disabled = true;
                withdrawAmountError.classList.add('d-none');
                withdrawModal.querySelectorAll('.amount-btn').forEach(btn => {
                    btn.classList.remove('selected');
                });
            });


        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration for all available tabs
            const tabs = [{
                    id: 'dashboard',
                    showSections: ['dashboard', 'student', 'transaction']
                },
                {
                    id: 'approval',
                    showSections: ['approval']
                },
                {
                    id: 'transactionHistory',
                    showSections: ['transactionHistory']
                },
                {
                    id: 'tableUsers',
                    showSections: ['tableUsers']
                }
            ];

            // All available content sections
            const allSections = [
                'dashboardContent',
                'studentContent',
                'transactionContent',
                'approvalContent',
                'transactionHistoryContent',
                'tableUsersContent'
            ];

            function switchTab(tabId) {
                // Find the tab configuration
                const tab = tabs.find(t => t.id === tabId);
                if (!tab) return;

                // Hide all sections first
                allSections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section) {
                        section.style.display = 'none';
                    }
                });

                // Show sections for the selected tab
                tab.showSections.forEach(section => {
                    const contentId = `${section}Content`;
                    const element = document.getElementById(contentId);
                    if (element) {
                        element.style.display = 'block';
                    }
                });

                // Update active states in the sidebar
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });

                // Add active class to the clicked link
                const activeLink = document.getElementById(`${tabId}Link`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }

                // Special handling for dashboard grid layout
                if (tabId === 'dashboard') {
                    const dashboardStats = document.querySelector('.dashboard-stats');
                    if (dashboardStats) {
                        dashboardStats.style.display = 'grid';
                    }
                }
            }

            // Add click event listeners to all nav links
            tabs.forEach(tab => {
                const link = document.getElementById(`${tab.id}Link`);
                if (link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        switchTab(tab.id);
                    });
                }
            });

            // Set dashboard as active by default
            switchTab('dashboard');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add Table Users link handler
            document.querySelector('a[href="#"].nav-link:nth-child(4)').addEventListener('click', function(e) {
                e.preventDefault();
                // Hide other content
                document.getElementById('dashboardContent').style.display = 'none';
                document.getElementById('studentContent').style.display = 'none';
                document.getElementById('transactionContent').style.display = 'none';
                document.getElementById('approvalContent').style.display = 'none';
                document.getElementById('transactionHistoryContent').style.display = 'none';

                // Show table users content
                document.getElementById('tableUsersContent').style.display = 'block';

                // Update active state
                document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            });

            // Edit User Modal
            const editUserModal = document.getElementById('editUserModal');
            if (editUserModal) {
                editUserModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const studentId = button.dataset.studentId;
                    const studentName = button.dataset.studentName;
                    const studentEmail = button.dataset.studentEmail;

                    // Update form action URL secara dinamis
                    const form = this.querySelector('#editUserForm');
                    form.action = `/bank_mini/update/${studentId}`;

                    // Populate form fields
                    this.querySelector('#editStudentId').value = studentId;
                    this.querySelector('#editName').value = studentName;
                    this.querySelector('#editEmail').value = studentEmail;
                    this.querySelector('#editPassword').value = ''; // Kosongkan password
                });
            }


            // Delete User Modal
            const deleteUserModal = document.getElementById('deleteUserModal');
            if (deleteUserModal) {
                deleteUserModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const studentId = button.dataset.studentId;
                    const studentName = button.dataset.studentName;

                    // Set the form action with the complete URL
                    const form = this.querySelector('#deleteUserForm');
                    form.action = `{{ route('users.destroy', '') }}/${studentId}`;

                    // Update confirmation message
                    this.querySelector('#deleteStudentName').textContent = studentName;
                    this.querySelector('#deleteStudentId').value = studentId;
                });
            }
        });
    </script>

</body>

</html>
