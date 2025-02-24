<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Admin</title>
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
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        .badge-info {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }
        .badge-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        .filter-dropdown {
            width: 200px;
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
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.transactions') }}">
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
        <div class="dashboard-header">
            <h2>Transaction History</h2>
            <div class="d-flex">
                <div class="search-box me-3">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search transactions...">
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card table-card">
            <div class="card-header">
                <h5 class="m-0">All Transactions</h5>
                <div class="d-flex align-items-center">
                    <select class="form-select filter-dropdown me-2" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <select class="form-select filter-dropdown" id="typeFilter">
                        <option value="">All Types</option>
                        <option value="transfer">Transfer</option>
                        <option value="deposit">Deposit</option>
                        <option value="withdrawal">Withdrawal</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->account->name }}</td>
                                <td>
                                    @if($transaction->type == 'transfer')
                                        <span class="badge badge-info">Transfer</span>
                                    @elseif($transaction->type == 'deposit')
                                        <span class="badge badge-success">Deposit</span>
                                    @else
                                        <span class="badge badge-warning">Withdrawal</span>
                                    @endif
                                </td>
                                <td>Rp. {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($transaction->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($transaction->status == 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $transaction->id }}">
                                        <i class="fas fa-eye"></i> Details
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Detail Modal for each transaction -->
                            <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Transaction Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Transaction ID:</div>
                                                <div class="col-7">#{{ $transaction->id }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">User:</div>
                                                <div class="col-7">{{ $transaction->account->name }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Type:</div>
                                                <div class="col-7">{{ ucfirst($transaction->type) }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Amount:</div>
                                                <div class="col-7">Rp. {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Status:</div>
                                                <div class="col-7">{{ ucfirst($transaction->status) }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Date:</div>
                                                <div class="col-7">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Description:</div>
                                                <div class="col-7">{{ $transaction->description ?? 'No description' }}</div>
                                            </div>
                                            @if(isset($transaction->recipient_id))
                                            <div class="row mb-3">
                                                <div class="col-5 fw-bold">Recipient:</div>
                                                <div class="col-7">{{ $transaction->recipient->name ?? 'Unknown' }}</div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            @if($transaction->status == 'pending')
                                                <form action="{{ route('admin.transaction.approve', $transaction->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.transaction.reject', $transaction->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('transactionsTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName('td');
                
                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.indexOf(searchValue) > -1) {
                        found = true;
                        break;
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        });
        
        // Filter by status
        document.getElementById('statusFilter').addEventListener('change', function() {
            filterTable();
        });
        
        // Filter by type
        document.getElementById('typeFilter').addEventListener('change', function() {
            filterTable();
        });
        
        function filterTable() {
            const statusValue = document.getElementById('statusFilter').value.toLowerCase();
            const typeValue = document.getElementById('typeFilter').value.toLowerCase();
            const table = document.getElementById('transactionsTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const statusCell = cells[4].textContent.toLowerCase();
                const typeCell = cells[2].textContent.toLowerCase();
                
                const statusMatch = statusValue === '' || statusCell.indexOf(statusValue) > -1;
                const typeMatch = typeValue === '' || typeCell.indexOf(typeValue) > -1;
                
                rows[i].style.display = statusMatch && typeMatch ? '' : 'none';
            }
        }
    </script>
</body>
</html>